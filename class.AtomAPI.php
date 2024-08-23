<?php 
class AtomAPI{
    public static function GetCurrentATOMApiKey()
    {
        $Obj = new SqlManager();
        $Obj->AddTbls('settings');
        $Obj->AddFlds(array('option_value'));
        $Obj->AddFldCond('option_name', 'ATOM_API_KEY');
        $Obj->GetSingle();
        $GetCurrentATOMApiKey = $Obj->GetSingle();
        define('ATOM_API_KEY', $GetCurrentATOMApiKey['option_value']);
 
    }
    public static function GetPropertiesToBeFetchedForAVM()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id, property_address, property_city, property_state, unit_number, property_zipcode FROM insights_main 
        WHERE ( inbestments_property_id IS NULL OR inbestments_property_id = 0 OR inbestments_property_id ='') AND checked_in_inbestments='Y'
        AND has_multi_match!='Y' AND ( attom_avm_fetched IS NULL   OR attom_avm_fetched ='')
        ".CONFIG_PROPERTY_CONDITION." ".AUTOMATION_CONDITION."
        AND insights_property_id NOT IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM."' AND  icf.cron_function_frequency='Monthly' AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
        AND insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN insights_cron_function_frequency icf ON icfs.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_IS_MAPPING_COMPLETED."' AND  icfs.cron_function_status_flag='Y'   )
        ORDER BY insights_property_id DESC
        LIMIT 10"; 
        return $Obj->GetQuery($Query);          
    }
    public static function GetPropertiesToBeFetchedForPDAndSH()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id, property_address, property_city, property_state, unit_number, property_zipcode FROM insights_main 
        WHERE  mortgage_fetched_from_attom IS NULL  AND checked_for_mortgage ='N' 
        ".CONFIG_PROPERTY_CONDITION." ".AUTOMATION_CONDITION."
        AND insights_property_id NOT IN (SELECT insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_PD_AND_SH."' AND  icf.cron_function_frequency='Monthly' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
        AND insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  
        insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_IS_MAPPING_COMPLETED."' 
        AND  icfs.cron_function_status_flag='Y'   )
        ORDER BY insights_property_id DESC
        LIMIT 10"; 
        echo '<BR>#2:: GetPropertiesToBeFetchedForPDAndSH<pre>'; 
        print_r($Query); 

        return $Obj->GetQuery($Query);  

    }
    public static function GetPropertiesToBeFetchedForAssessment()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id,property_address,property_city,property_state,property_zipcode 
            FROM insights_main WHERE (
                (assessment_fetched_date IS NULL AND assessment_checked_date IS NULL) 
                OR (assessment_fetched_date <= DATE_SUB(NOW(), INTERVAL '0' YEAR) 
                AND assessment_checked_date <= DATE_SUB(NOW(), INTERVAL '0' YEAR))
                ) 
                AND ( primary_owner_id = 1495 OR  primary_owner_id = 1452 OR  primary_owner_id = 1238 OR  primary_owner_id = 1402)
                 LIMIT 8";
        return $Obj->GetQuery($Query);
    }
    public static function GetUSPSAddressToBeFetchedForPDAndSH()
    {
    
        $Obj = new SqlManager();
        $Query = "	SELECT im.insights_property_id insights_property_id, usps.address2 property_address, usps.city property_city, usps.state property_state, usps.zip5  property_zipcode
        FROM insights_main im LEFT JOIN insights_address_usps usps ON im.insights_property_id = usps.insights_property_id
        WHERE im.address_checked_for_mortgage ='Y' AND im.mortgage_fetched_after_address_validation IS NULL AND usps.address2 !=''
        AND ( usps.error IS NULL OR usps.error='')  
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.property_address NOT LIKE '123 Main Street' 
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_GET_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH."'  AND  icf.cron_function_frequency='Monthly' AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
        AND im.insights_property_id IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_IS_MAPPING_COMPLETED."' AND  icfs.cron_function_status_flag='Y'   )
        ORDER BY im.insights_property_id DESC
        LIMIT 5 "; 
        return $Obj->GetQuery($Query); 

    
    }
    public static function GetAbbUSPSAddressToBeFetchedForPDAndSH()
    {
    
        $Obj = new SqlManager();
        $Query = "	SELECT im.insights_property_id insights_property_id, usps.address2abbreviation property_address, usps.city property_city, usps.state property_state, usps.zip5  property_zipcode
        FROM insights_main im LEFT JOIN insights_address_usps usps ON im.insights_property_id = usps.insights_property_id
        WHERE im.address_checked_for_mortgage ='Y' AND im.mortgage_fetched_after_address_validation = 'N' AND usps.address2abbreviation !=''
        AND im.mortgage_fetched_using_usps_abb_address IS NULL
        AND ( usps.error IS NULL OR usps.error='')  
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.property_address NOT LIKE '123 Main Street' 
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_GET_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH."'  AND  icf.cron_function_frequency='Monthly' AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )
        AND im.insights_property_id IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_IS_MAPPING_COMPLETED."' AND  icfs.cron_function_status_flag='Y'   )
        ORDER BY im.insights_property_id DESC
        LIMIT 5 ";       
        return $Obj->GetQuery($Query); 

    }
    public static function FetchDataFromATOM($AvmProperties, $MortgageProperties, $Assessment, $MortgageFromUSPS, $MortgageFromUSPSAbb)
    {
        $InsightsPropertyId=0;
        foreach ($AvmProperties as $Property) {
            self::FetchPropertyAVMSales($Property);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_ATTOM_API_COMPLETED,'Y');
            $InsightsPropertyId = (isset($Property['insights_property_id']) && $Property['insights_property_id']!='' ) ? $Property['insights_property_id'] : $InsightsPropertyId;
        }
        

        foreach ($MortgageProperties as $Property) {
            self::FetchSalesHistory($Property,true, false, CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_PD_AND_SH);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_ATTOM_API_COMPLETED,'Y');
            $InsightsPropertyId = (isset($Property['insights_property_id']) && $Property['insights_property_id']!='' ) ? $Property['insights_property_id'] : $InsightsPropertyId;
        }
       
        foreach ($Assessment as $Property) {
            self::FetchPropertyAssessment($Property);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_ATTOM_API_COMPLETED,'Y');
            $InsightsPropertyId = (isset($Property['insights_property_id']) && $Property['insights_property_id']!='' ) ? $Property['insights_property_id'] : $InsightsPropertyId;
        }
       
        foreach ($MortgageFromUSPS as $Property) {
            self::FetchSalesHistory($Property, false,true,CONFIG_GET_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_ATTOM_API_COMPLETED,'Y');
            $InsightsPropertyId = (isset($Property['insights_property_id']) && $Property['insights_property_id']!='' ) ? $Property['insights_property_id'] : $InsightsPropertyId;
        }
        foreach ($MortgageFromUSPSAbb as $Property) {
            self::FetchSalesHistory($Property, false, true, CONFIG_GET_ABB_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_ATTOM_API_COMPLETED,'Y');
            $InsightsPropertyId = (isset($Property['insights_property_id']) && $Property['insights_property_id']!='' ) ? $Property['insights_property_id'] : $InsightsPropertyId;
        }
         
        self::UpdateHomeFactStatus($InsightsPropertyId);

    }
    public static function UpdateHomeFactStatus($InsightsPropertyId)
    {
        $Query = "SELECT ap.insights_property_id
        FROM insights_main im, insights_attom_property ap 
        WHERE im.insights_property_id = ap.insights_property_id 
        AND im.atttom_property_details_fetched != 'Y' 
        AND ap.location_latitude != 0 
        AND ap.location_longitude != 0 
        AND ap.living_size > 0";

        $Obj = new SqlManager();
        $Data = $Obj->GetQuery($Query);

        foreach ($Data as $Item) {
            self::UpdateFetchedStatus('atttom_property_details_fetched', $Item['insights_property_id']);
        }
        $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($InsightsPropertyId, CONFIG_IS_ATTOM_API_COMPLETED,'Y');
    }
    private static function FetchPropertyAVMSales($Property)
    {
        $ch = self::GetCurlInstance();
        curl_setopt($ch, CURLOPT_URL, ATOM_AVM_ENDPOINT.'?'.self::FormAddressString($Property));
        
        $AVMRes = curl_exec($ch);
        self::InsertAPIResponse(array(
                'insights_property_id' => $Property['insights_property_id'],
                'api_response' => $AVMRes,
                'api_name' => 'avm'
            )
        );

        $AVMResObj = json_decode($AVMRes);
        
        $PropertyResArr = self::ParseExtendedData($AVMResObj);
      
        // echo 'FetchSalesHistory->Property:: <pre>';
        // print_r($Property);
        // echo 'FetchPropertyAVMSales->ATOM_AVM_ENDPOINT:: PropertyResArr :: <pre>';
        // print_r($PropertyResArr); 

        if (count((array)$PropertyResArr)) {
            if (isset( $PropertyResArr['summary_absentee_ind']) &&  $PropertyResArr['summary_absentee_ind']!="" ){
                $OwnerOccupied = (  $PropertyResArr['summary_absentee_ind']=="OWNER OCCUPIED" )?  "Y" : "N";
            }else{
                $OwnerOccupied=null;
            }
           
            $CheckTable = self::CheckATOMTable('insights_attom_property', $Property['insights_property_id']);
            if (!count((array)$CheckTable)) {
                // echo 'UPDATE ###1';
                $PropertyResArr['insights_property_id'] = $Property['insights_property_id'];
                $insightsAttomProperty = self::InsertATOMTable('insights_attom_property', $PropertyResArr);
                print_r('$insightsAttomProperty:: ');
                print_r($insightsAttomProperty);

                self::UpdateInsightsMain( array(
                    'bedroom' => $PropertyResArr['beds'], 
                    'bedroom_src' => 'tbl_insights_attom_property', 
                    'bathroom' => $PropertyResArr['baths_total'],
                    'bathroom_src' => 'tbl_insights_attom_property',  
                    'square_foot' => $PropertyResArr['living_size'],
                    'square_foot_src' => 'tbl_insights_attom_property',
                    'owner_occupied' => $OwnerOccupied,  
                    ),$Property['insights_property_id']
                );      
  
                $AuditHistoryParam1 = array( 
                    array( 'changed_column_name' => 'bedroom',  'column_new_value' => $PropertyResArr['beds']), 
                    array( 'changed_column_name' => 'bathroom', 'column_new_value' => $PropertyResArr['baths_total']),
                    array( 'changed_column_name' => 'square_foot', 'column_new_value' => $PropertyResArr['living_size']),
                ); 
                $AuditHistoryParam = array(
                    'table_name' => 'tbl_insights_attom_property', 
                    'table_primary_key_name' => 'id',
                    'table_primary_key_value' => 0, 
                    'insights_property_id' => $Property['insights_property_id'],
                    'column_source' => 'cron_attom_avm',
                    'property_details'=> $AuditHistoryParam1
                );
                // echo '=========Find@222=====';
                // print_r($AuditHistoryParam);
                // echo '###1';
                $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);  
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AttomAVMAdded,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                                       
            } else {
                // echo 'UPDATE ###2';
                self::UpdateATOMTable('insights_attom_property', $PropertyResArr, $CheckTable['id']);
                self::UpdateInsightsMain( array(
                    'bedroom' => $PropertyResArr['beds'], 
                    'bedroom_src' => 'tbl_insights_attom_property', 
                    'bathroom' => $PropertyResArr['baths_total'],
                    'bathroom_src' => 'tbl_insights_attom_property',  
                    'square_foot' => $PropertyResArr['living_size'],
                    'square_foot_src' => 'tbl_insights_attom_property',  
                    'owner_occupied' => $OwnerOccupied,  
                    ),$Property['insights_property_id']
                );      
                $AuditHistoryParam1 = array( 
                    array( 'changed_column_name' => 'bedroom',  'column_new_value' => $PropertyResArr['beds']), 
                    array( 'changed_column_name' => 'bathroom', 'column_new_value' => $PropertyResArr['baths_total']),
                    array( 'changed_column_name' => 'square_foot', 'column_new_value' => $PropertyResArr['living_size']),
                ); 
                $AuditHistoryParam = array(
                    'table_name' => 'tbl_insights_attom_property', 
                    'table_primary_key_name' => 'id',
                    'table_primary_key_value' => $CheckTable['id'], 
                    'insights_property_id' => $Property['insights_property_id'],
                    'column_source' => 'cron_attom_avm',
                    'column_value_stored_in' => 'tbl_insights_attom_property',
                    'property_details'=> $AuditHistoryParam1
                );
                echo '###2';
                $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);     
                $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);  
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AttomAVMUpdated,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);       
            }
        }else{
            $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => DataNotReturnedByApi,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
        }
        
        $AVMResArr = self::ParseAVMData($AVMResObj);
        // echo 'AVMResArr::<pre>';
        // print_r($AVMResArr);  
            
        if (count((array)$AVMResArr)) {
            // echo "1.1::";
            $CheckAVMTable = self::CheckATOMTable('insights_attom_avm', $Property['insights_property_id']);
            if (!count((array)$CheckAVMTable)) {
                $AVMResArr['insights_property_id'] = $Property['insights_property_id'];
                self::InsertATOMTable('insights_attom_avm', $AVMResArr);
                self::UpdateFetchedStatus('attom_avm_fetched', $Property['insights_property_id']);
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AttomAVMFetched, 'attom_avm_fetched' => 'Y', 'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
                // echo "1.2::"; 

            }
            SIFlagIssues::UpdateInsightIssuesForAddressFound($Property['insights_property_id']);
        } else{
            
            self::UpdateFetchedStatus('attom_avm_fetched', $Property['insights_property_id'], 'N');
            self::UpdateOrInsertInsightIssues($Property['insights_property_id']);
            $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => AttomAVMNotFetched, 'attom_avm_fetched' => 'Y', 'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);    
            // echo "1.3::";        
        }
        // echo "1.4::";
      
        curl_close($ch);
        return ["AVMResponse"=>$AVMResArr,"Property"=>$AVMResObj];
    }

    private static function FetchSalesHistory($Property, $Flag = true, $AbbFlag = false,$CronFunctionName)
    {
        $ch = self::GetCurlInstance();
        curl_setopt($ch, CURLOPT_URL, ATOM_SALES_HISTORY_ENDPOINT.'?'.self::FormAddressString($Property));
        
        $PropertyRes = curl_exec($ch);
        self::InsertAPIResponse(array(
                'insights_property_id' => $Property['insights_property_id'],
                'api_response' => $PropertyRes,
                'api_name' => 'sales-history'
            )
        );

        $PropertyResObj = json_decode($PropertyRes);
        $PropertyResArr = self::ParseExtendedData($PropertyResObj);
        echo 'FetchSalesHistory->Property:: <pre>';
        print_r($Property);
        echo 'FetchSalesHistory->ATOM_SALES_HISTORY_ENDPOINT:: PropertyResArr :: <pre>';
        print_r($PropertyResArr); 
        echo count((array)$PropertyResArr); 
        echo '<br>ATOM_SALES_HISTORY_ENDPOINT#1.1 :: ';

        if (count((array)$PropertyResArr)) {
            echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.1 :: ';
            $CheckTable = self::CheckATOMTable('insights_attom_property', $Property['insights_property_id']);
            if (!count((array)$CheckTable)) {
                echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.2';
                $PropertyResArr['insights_property_id'] = $Property['insights_property_id'];
                
                $insightsAttomProperty = self::InsertATOMTable('insights_attom_property', $PropertyResArr);
                print_r('$insightsAttomProperty:: ');
                print_r($insightsAttomProperty);
                echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.3';

                    self::UpdateInsightsMain( array(
                        'year_built' => $PropertyResArr['summary_year_built'],
                        'year_built_src' => 'tbl_insights_attom_property'
                        ), $Property['insights_property_id']
                    );   
                    $AuditHistoryParam1 = array( 
                        array( 'changed_column_name' => 'year_built', 'column_new_value' => $PropertyResArr['summary_year_built']),
                    ); 
                    $AuditHistoryParam = array(
                        'table_name' => 'tbl_insights_attom_property', 
                        'table_primary_key_name' => 'id',
                        'table_primary_key_value' => 0,  
                        'insights_property_id' => $Property['insights_property_id'],
                        'column_source' => 'attom_sales_history_endpoint',
                        'column_value_stored_in' => 'tbl_insights_attom_property',
                        'property_details'=> $AuditHistoryParam1
                    );
                    $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);                         
               
                    echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.4';
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
                    'cron_function_status_flag' => AttomSalesMortgageHistoryAdded,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);

            } else {
                self::UpdateATOMTable('insights_attom_property', $PropertyResArr, $CheckTable['id']);
                echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.5';
                    self::UpdateInsightsMain( array(
                        'year_built' => $PropertyResArr['summary_year_built'],
                        'year_built_src' => 'tbl_insights_attom_property'
                        ), $Property['insights_property_id']
                    );       
                    $AuditHistoryParam1 = array( 
                        array( 'changed_column_name' => 'year_built', 'column_new_value' => $PropertyResArr['summary_year_built']),
                    ); 
                    $AuditHistoryParam = array(
                        'table_name' => 'tbl_insights_attom_property', 
                        'table_primary_key_name' => 'id',
                        'table_primary_key_value' => $CheckTable['id'],  
                        'insights_property_id' => $Property['insights_property_id'],
                        'column_source' => 'cron_attom',
                        'column_value_stored_in' => 'tbl_insights_attom_property',
                        'property_details'=> $AuditHistoryParam1
                    );
                    $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);                         
                    echo '<br>ATOM_SALES_HISTORY_ENDPOINT #2.6';
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
                    'cron_function_status_flag' => AttomSalesMortgageHistoryUpdated,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                            
            }
        }else {
            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => DataNotReturnedByApi,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);

        }
        echo 'ATOM_SALES_HISTORY_ENDPOINT#3.1';
        $MortgageStatusField = 'mortgage_fetched_from_attom';
        if (!$Flag)
            $MortgageStatusField = 'mortgage_fetched_after_address_validation';
        if ($AbbFlag)
            $MortgageStatusField = 'mortgage_fetched_using_usps_abb_address';    


        $PropertyReArr = self::ParseSalesHistory($PropertyResObj);
        // echo 'PropertyReArr::<pre>';
        // print_r($PropertyReArr);        
        if (count((array)$PropertyReArr)) {
            foreach ($PropertyReArr as $Item) {
                if (isset($Item['transaction_ident'])) {
                    $CheckTable = self::CheckATOMSalesHistory($Property['insights_property_id'], $Item['transaction_ident']);
                    if (!count((array)$CheckTable)) {
                        $Item['insights_property_id'] = $Property['insights_property_id'];
                        $insightsAttomSalesMH = self::InsertATOMTable('insights_attom_sales_mortgage_history', $Item);
                        echo '$insightsAttomSalesMH::'; 
                        print_r($insightsAttomSalesMH);
                        if($Item['sale_trans_type']== 'New Construction' || $Item['sale_trans_type']== 'Resale'){
                            self::UpdateInsightsMain(array(
                                'purchase_date' => $Item['sale_trans_date'], 
                                'purchase_date_src' => 'tbl_insights_attom_sales_mortgage_history', 
                                'purchase_price' => $Item['sale_amt'],
                                'purchase_price_src' => 'tbl_insights_attom_sales_mortgage_history'
                                ), $Property['insights_property_id']
                            );     
                            
                       
                            $AuditHistoryParam1 = array( 
                                array( 'changed_column_name' => 'purchase_price', 'column_new_value' => $Item['sale_trans_date']),
                                array( 'changed_column_name' => 'purchase_date', 'column_new_value' => $Item['sale_amt']),
                            ); 
                            $AuditHistoryParam = array(
                                'table_name' => 'insights_attom_sales_mortgage_history', 
                                'table_primary_key_name' => 'id',
                                'table_primary_key_value' => 0,  
                                'insights_property_id' => $Property['insights_property_id'],
                                'column_source' => 'cron_attom',
                                                             
                                'property_details'=> $AuditHistoryParam1
                            );

                            $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);                                 
                        }
                                              
                        $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
                        'cron_function_status_flag' => AttomSalesMortgageHistoryAdded,$MortgageStatusField=>'Y',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);

                    }
                }
            }
            self::UpdateFetchedStatus($MortgageStatusField, $Property['insights_property_id']);
            SIFlagIssues::UpdateInsightIssuesForAddressFound($Property['insights_property_id']);
        } else{
            self::UpdateFetchedStatus($MortgageStatusField, $Property['insights_property_id'], 'N');
            self::UpdateOrInsertInsightIssues($Property['insights_property_id']);
            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => AttomSalesMortgageHistoryAdded,$MortgageStatusField=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);            
        }

        if ($Flag)
        {
            self::UpdateFetchedStatus('checked_for_mortgage', $Property['insights_property_id']);
            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => CheckedForMortgage,'checked_for_mortgage'=>'Y',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);              
        }
            

        curl_close($ch);
        return $PropertyReArr;
    }
    private static function ParseAVMData($Data)
    {
        $AVM = array();

        if (count((array)$Data)
            && isset($Data->status) 
            && isset($Data->status->msg) 
            && $Data->status->msg == 'SuccessWithResult') {

            if (isset($Data->property) && count((array)$Data->property)) {
                $Property = $Data->property[0];

                if (isset($Property->avm) && count((array)$Property->avm)) {
                    if (isset($Property->identifier) && count((array)$Property->identifier)) {
                        if (isset($Property->identifier->obPropId))
                            $AVM['ob_prop_id'] = $Property->identifier->obPropId;
                        if (isset($Property->identifier->fips))    
                            $AVM['fips'] = $Property->identifier->fips;
                        if (isset($Property->identifier->apn))
                            $AVM['apn'] = $Property->identifier->apn;
                        if (isset($Property->identifier->attomID))
                            $AVM['attom_id'] = $Property->identifier->attomID;
                    }

                    if (isset($Property->avm->eventDate))
                        $AVM['event_date'] = $Property->avm->eventDate;

                    if (isset($Property->avm->amount) && count((array)$Property->avm->amount)) {
                        if (isset($Property->avm->amount->scr))
                            $AVM['scr'] = $Property->avm->amount->scr;
                        if (isset($Property->avm->amount->value))
                            $AVM['value'] = $Property->avm->amount->value;
                        if (isset($Property->avm->amount->high))
                            $AVM['high'] = $Property->avm->amount->high;
                        if (isset($Property->avm->amount->low))
                            $AVM['low'] = $Property->avm->amount->low;
                        if (isset($Property->avm->amount->fsd))
                            $AVM['fsd'] = $Property->avm->amount->fsd;
                    }
                }
            }
        }
        return $AVM;
    }
    private static function CheckATOMSalesHistory($InsightsPropertyID, $TransactionIdent)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_attom_sales_mortgage_history'));
        $Obj->AddFlds(array('insights_property_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('transaction_ident', $TransactionIdent);
        return $Obj->GetSingle();
    }

    private static function FetchPropertyAssessment($Property)
    {
        $ch = self::GetCurlInstance();
        curl_setopt($ch, CURLOPT_URL, ATOM_ASSESSMENT_ENDPOINT.'?'.self::FormAddressString($Property));
        
        $AssessmentRes = curl_exec($ch);
        self::InsertAPIResponse(array(
                'insights_property_id' => $Property['insights_property_id'],
                'api_response' => $AssessmentRes,
                'api_name' => 'assessment'
            )
        );

        $AssessmentResObj = json_decode($AssessmentRes);
        
        $PropertyResArr = self::ParseAssessmentData($AssessmentResObj);

        echo 'FetchSalesHistory->Property:: <pre>';
        print_r($Property);
        echo 'FetchPropertyAVMSales->ATOM_ASSESSMENT_ENDPOINT:: PropertyResArr :: <pre>';
        print_r($PropertyResArr); 
        echo count((array)$PropertyResArr);
        
        if (count((array)$PropertyResArr)) {
            echo '2.1#ATOM_ASSESSMENT_ENDPOINT::';
            $CheckTable = self::CheckATOMTable('insights_attom_assessment', $Property['insights_property_id']);
            if (!count((array)$CheckTable)) {
                $PropertyResArr['insights_property_id'] = $Property['insights_property_id'];
                self::InsertATOMTable('insights_attom_assessment', $PropertyResArr);
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_ASSESSMENT, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AttomAssessmentAdded, 'assessment_checked_date' => date(DB_DATETIME_FORMAT) , 'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 

            } else {
                self::UpdateATOMTable('insights_attom_assessment', $PropertyResArr, $CheckTable['id']);
                $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_ASSESSMENT, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AttomAssessmentUpdated,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                
            }
            self::UpdateInsightsMain(array('assessment_checked_date' => date(DB_DATETIME_FORMAT), 'assessment_fetched_date' => date(DB_DATETIME_FORMAT)), $Property['insights_property_id']);
            // SIFlagIssues::UpdateInsightIssuesForAddressFound($Property['insights_property_id']);
                    
        } else{
            $Parms = array('cron_function_name' => CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_ASSESSMENT, 'insights_property_id' => $Property['insights_property_id'], 
            'cron_function_status_flag' => DataNotReturnedByApi,'assessment_checked_date' => date(DB_DATETIME_FORMAT),  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
        }
        
        curl_close($ch);
        return $PropertyResArr;
    }
    
    public static function GetCurlInstance()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'apikey: ' . ATOM_API_KEY
            )
        );
        return $ch;
    }
    
    private static function InsertAPIResponse($Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_attom_api_response'));
        $Obj->AddInsrtFlds($Data);
        return $Obj->InsertSingle();
    }
    private static function ParseAssessmentData($Data)
    {
        $Res = array();
        if (isset($Data->status) 
            && isset($Data->status->msg) 
            && $Data->status->msg == 'SuccessWithResult') {
            if (isset($Data->property) && count($Data->property)) {
                $Property = $Data->property[0];
                if (isset($Property->identifier) && count($Property->identifier)) {
                    if (isset($Property->identifier->obPropId))
                        $Res['ob_prop_id'] = $Property->identifier->obPropId;
                    if (isset($Property->identifier->fips))    
                        $Res['fips'] = $Property->identifier->fips;
                    if (isset($Property->identifier->apn))
                        $Res['apn'] = $Property->identifier->apn;
                    if (isset($Property->identifier->attomId))
                        $Res['attom_id'] = $Property->identifier->attomId;
                }

                if (isset($Property->assessment) && count($Property->assessment)) {
                    $Assessment = $Property->assessment;
                    if (isset($Assessment->appraised) && count($Assessment->appraised)) {
                        if (isset($Assessment->appraised->apprimprvalue))
                            $Res['apprimprvalue'] = $Assessment->appraised->apprimprvalue;
                        if (isset($Assessment->appraised->apprlandvalue))
                            $Res['apprlandvalue'] = $Assessment->appraised->apprlandvalue;
                        if (isset($Assessment->appraised->apprttlvalue))
                            $Res['apprttlvalue'] = $Assessment->appraised->apprttlvalue;
                    }

                    if (isset($Assessment->assessed) && count($Assessment->assessed)) {
                        if (isset($Assessment->assessed->assdimprpersizeunit))
                            $Res['assdimprpersizeunit'] = $Assessment->assessed->assdimprpersizeunit;
                        if (isset($Assessment->assessed->assdimprvalue))
                            $Res['assdimprvalue'] = $Assessment->assessed->assdimprvalue;
                        if (isset($Assessment->assessed->assdlandpersizeunit))
                            $Res['assdlandpersizeunit'] = $Assessment->assessed->assdlandpersizeunit;
                        if (isset($Assessment->assessed->assdlandvalue))
                            $Res['assdlandvalue'] = $Assessment->assessed->assdlandvalue;
                        if (isset($Assessment->assessed->assdttlpersizeunit))
                            $Res['assdttlpersizeunit'] = $Assessment->assessed->assdttlpersizeunit;
                        if (isset($Assessment->assessed->assdttlvalue))
                            $Res['assdttlvalue'] = $Assessment->assessed->assdttlvalue;
                    }

                    if (isset($Assessment->calculations) && count($Assessment->calculations)) {
                        if (isset($Assessment->calculations->calcimprind))
                            $Res['calcimprind'] = $Assessment->calculations->calcimprind;
                        if (isset($Assessment->calculations->calcimprpersizeunit))
                            $Res['calcimprpersizeunit'] = $Assessment->calculations->calcimprpersizeunit;
                        if (isset($Assessment->calculations->calcimprvalue))
                            $Res['calcimprvalue'] = $Assessment->calculations->calcimprvalue;
                        if (isset($Assessment->calculations->calclandind))
                            $Res['calclandind'] = $Assessment->calculations->calclandind;
                        if (isset($Assessment->calculations->calclandpersizeunit))
                            $Res['calclandpersizeunit'] = $Assessment->calculations->calclandpersizeunit;
                        if (isset($Assessment->calculations->calclandvalue))
                            $Res['calclandvalue'] = $Assessment->calculations->calclandvalue;
                        if (isset($Assessment->calculations->calcttlind))
                            $Res['calcttlind'] = $Assessment->calculations->calcttlind;
                        if (isset($Assessment->calculations->calcttlvalue))
                            $Res['calcttlvalue'] = $Assessment->calculations->calcttlvalue;
                        if (isset($Assessment->calculations->calcvaluepersizeunit))
                            $Res['calcvaluepersizeunit'] = $Assessment->calculations->calcvaluepersizeunit;
                    }

                    if (isset($Assessment->market) && count($Assessment->market)) {
                        if (isset($Assessment->market->mktimprvalue))
                            $Res['mktimprvalue'] = $Assessment->market->mktimprvalue;
                        if (isset($Assessment->market->mktlandvalue))
                            $Res['mktlandvalue'] = $Assessment->market->mktlandvalue;
                        if (isset($Assessment->market->mktttlvalue))
                            $Res['mktttlvalue'] = $Assessment->market->mktttlvalue;
                    }

                    if (isset($Assessment->tax) && count($Assessment->tax)) {
                        if (isset($Assessment->tax->taxamt))
                            $Res['taxamt'] = $Assessment->tax->taxamt;
                        if (isset($Assessment->tax->taxpersizeunit))
                            $Res['taxpersizeunit'] = $Assessment->tax->taxpersizeunit;
                        if (isset($Assessment->tax->taxyear))
                            $Res['taxyear'] = $Assessment->tax->taxyear;
                    }
                }
            }
        }
        return $Res;
    }
    private static function ParseSalesHistory($Data)
    {
        $Res = array();
        if (isset($Data->status) 
            && isset($Data->status->msg) 
            && $Data->status->msg == 'SuccessWithResult') {
            if (isset($Data->property) && count((array)$Data->property)) {
                $Property = $Data->property[0];

                if (isset($Property->identifier) && count((array)$Property->identifier)) {
                    $PropIdentity = array();
                    if (isset($Property->identifier->obPropId))
                        $PropIdentity['ob_prop_id'] = $Property->identifier->obPropId;
                    if (isset($Property->identifier->fips))    
                        $PropIdentity['fips'] = $Property->identifier->fips;
                    if (isset($Property->identifier->apn))
                        $PropIdentity['apn'] = $Property->identifier->apn;
                    if (isset($Property->identifier->attomId))
                        $PropIdentity['attom_id'] = $Property->identifier->attomId;

                    if (isset($Property->saleHistory) && count((array)$Property->saleHistory)) {
                        $SHArray = array();
                        foreach ($Property->saleHistory as $Item) {
                            if (isset($Item->sequence))
                                $SHArray['sequence'] = $Item->sequence;
                            if (isset($Item->saleSearchDate))
                                $SHArray['sale_search_date'] = $Item->saleSearchDate;
                            if (isset($Item->saleTransDate))
                                $SHArray['sale_trans_date'] = $Item->saleTransDate;
                            if (isset($Item->transactionIdent))
                                $SHArray['transaction_ident'] = $Item->transactionIdent;
                            if (isset($Item->armsLengthIdent))
                                $SHArray['arms_length_ident'] = $Item->armsLengthIdent;
                            if (isset($Item->recorderThroughDate))
                                $SHArray['recorder_through_date'] = $Item->recorderThroughDate;
                            if (isset($Item->buyerName))
                                $SHArray['buyer_name'] = $Item->buyerName;
                            if (isset($Item->sellerName))
                                $SHArray['seller_name'] = $Item->sellerName;
                            if (isset($Item->deedInLieuOfIndicator))
                                $SHArray['deed_in_lieu_of_indicator'] = $Item->deedInLieuOfIndicator;

                            if (isset($Item->amount) && count((array)$Item->amount)) {
                                if (isset($Item->amount->saleAmt))
                                    $SHArray['sale_amt'] = $Item->amount->saleAmt;
                                if (isset($Item->amount->saleRecDate))
                                    $SHArray['sale_rec_date'] = $Item->amount->saleRecDate;
                                if (isset($Item->amount->saleDisclosureType))
                                    $SHArray['sale_disclosure_type'] = $Item->amount->saleDisclosureType;
                                if (isset($Item->amount->saleDocNum))
                                    $SHArray['sale_doc_num'] = $Item->amount->saleDocNum;
                                if (isset($Item->amount->saleTransType))
                                    $SHArray['sale_trans_type'] = $Item->amount->saleTransType;
                                if (isset($Item->amount->propIndicator))
                                    $SHArray['prop_indicator'] = $Item->amount->propIndicator;
                                if (isset($Item->amount->deedType))
                                    $SHArray['deed_type'] = $Item->amount->deedType;
                            }

                            if (isset($Item->title) && count((array)$Item->title)) {
                                if (isset($Item->title->companyName))
                                    $SHArray['company_name'] = $Item->title->companyName;
                                if (isset($Item->title->companyCode))
                                    $SHArray['company_code'] = $Item->title->companyCode;
                            }

                            if (isset($Item->mortgage) && count((array)$Item->mortgage)) {
                                $Mortgage = $Item->mortgage;
                                if (isset($Mortgage->FirstConcurrent) && count((array)$Mortgage->FirstConcurrent)) {
                                    if (isset($Mortgage->FirstConcurrent->trustDeedDocumentNumber))
                                        $SHArray['fc_trust_deed_document_number'] = $Mortgage->FirstConcurrent->trustDeedDocumentNumber;
                                    if (isset($Mortgage->FirstConcurrent->amount))
                                        $SHArray['fc_amount'] = $Mortgage->FirstConcurrent->amount;
                                    if (isset($Mortgage->FirstConcurrent->lenderLastName))
                                        $SHArray['fc_lender_last_name'] = $Mortgage->FirstConcurrent->lenderLastName;
                                    if (isset($Mortgage->FirstConcurrent->companyCode))
                                        $SHArray['fc_company_code'] = $Mortgage->FirstConcurrent->companyCode;
                                    if (isset($Mortgage->FirstConcurrent->date))
                                        $SHArray['fc_date'] = $Mortgage->FirstConcurrent->date;
                                    if (isset($Mortgage->FirstConcurrent->interestRate))
                                        $SHArray['fc_interest_rate'] = $Mortgage->FirstConcurrent->interestRate;
                                    if (isset($Mortgage->FirstConcurrent->loanTypeCode))
                                        $SHArray['fc_loan_type_code'] = $Mortgage->FirstConcurrent->loanTypeCode;
                                    if (isset($Mortgage->FirstConcurrent->term))
                                        $SHArray['fc_term'] = $Mortgage->FirstConcurrent->term;
                                    if (isset($Mortgage->FirstConcurrent->dueDate))
                                        $SHArray['fc_due_date'] = $Mortgage->FirstConcurrent->dueDate;
                                    if (isset($Mortgage->FirstConcurrent->interestRateType))
                                        $SHArray['fc_interest_rate_type'] = $Mortgage->FirstConcurrent->interestRateType;
                                    if (isset($Mortgage->FirstConcurrent->equityFlag))
                                        $SHArray['fc_equity_flag'] = $Mortgage->FirstConcurrent->equityFlag;
                                    if (isset($Mortgage->FirstConcurrent->interestMargin))
                                        $SHArray['fc_interest_margin'] = $Mortgage->FirstConcurrent->interestMargin;
                                    if (isset($Mortgage->FirstConcurrent->mortgageInterestIndex))
                                        $SHArray['fc_mortgage_interest_index'] = $Mortgage->FirstConcurrent->mortgageInterestIndex;
                                    if (isset($Mortgage->FirstConcurrent->mortgageInterestRateMax))
                                        $SHArray['fc_mortgage_interest_rate_max'] = $Mortgage->FirstConcurrent->mortgageInterestRateMax;                                        
                                }
                                if (isset($Mortgage->SecondConcurrent) && count((array)$Mortgage->SecondConcurrent)) {
                                    if (isset($Mortgage->SecondConcurrent->trustDeedDocumentNumber))
                                        $SHArray['sc_trust_deed_document_number'] = $Mortgage->SecondConcurrent->trustDeedDocumentNumber;
                                    if (isset($Mortgage->SecondConcurrent->amount))
                                        $SHArray['sc_amount'] = $Mortgage->SecondConcurrent->amount;
                                    if (isset($Mortgage->SecondConcurrent->lenderLastName))
                                        $SHArray['sc_lender_last_name'] = $Mortgage->SecondConcurrent->lenderLastName;
                                    if (isset($Mortgage->SecondConcurrent->companyCode))
                                        $SHArray['sc_company_code'] = $Mortgage->SecondConcurrent->companyCode;
                                    if (isset($Mortgage->SecondConcurrent->date))
                                        $SHArray['sc_date'] = $Mortgage->SecondConcurrent->date;
                                    if (isset($Mortgage->SecondConcurrent->interestRate))
                                        $SHArray['sc_interest_rate'] = $Mortgage->SecondConcurrent->interestRate;
                                    if (isset($Mortgage->SecondConcurrent->loanTypeCode))
                                        $SHArray['sc_loan_type_code'] = $Mortgage->SecondConcurrent->loanTypeCode;
                                    if (isset($Mortgage->SecondConcurrent->term))
                                        $SHArray['sc_term'] = $Mortgage->SecondConcurrent->term;
                                    if (isset($Mortgage->SecondConcurrent->dueDate))
                                        $SHArray['sc_due_date'] = $Mortgage->SecondConcurrent->dueDate;
                                    if (isset($Mortgage->SecondConcurrent->interestRateType))
                                        $SHArray['sc_interest_rate_type'] = $Mortgage->SecondConcurrent->interestRateType;
                                    if (isset($Mortgage->SecondConcurrent->equityFlag))
                                        $SHArray['sc_equity_flag'] = $Mortgage->SecondConcurrent->equityFlag;
                                    if (isset($Mortgage->SecondConcurrent->interestMargin))
                                        $SHArray['sc_interest_margin'] = $Mortgage->SecondConcurrent->interestMargin;
                                    if (isset($Mortgage->SecondConcurrent->mortgageInterestIndex))
                                        $SHArray['sc_mortgage_interest_index'] = $Mortgage->SecondConcurrent->mortgageInterestIndex;
                                    if (isset($Mortgage->SecondConcurrent->mortgageInterestRateMax))
                                        $SHArray['sc_mortgage_interest_rate_max'] = $Mortgage->SecondConcurrent->mortgageInterestRateMax;
                                }
                                if (isset($Mortgage->ThirdConcurrent) && count((array)$Mortgage->ThirdConcurrent)) {
                                    if (isset($Mortgage->ThirdConcurrent->trustDeedDocumentNumber))
                                        $SHArray['tc_trust_deed_document_number'] = $Mortgage->ThirdConcurrent->trustDeedDocumentNumber;
                                    if (isset($Mortgage->ThirdConcurrent->amount))
                                        $SHArray['tc_amount'] = $Mortgage->ThirdConcurrent->amount;
                                    if (isset($Mortgage->ThirdConcurrent->lenderLastName))
                                        $SHArray['tc_lender_last_name'] = $Mortgage->ThirdConcurrent->lenderLastName;
                                    if (isset($Mortgage->ThirdConcurrent->companyCode))
                                        $SHArray['tc_company_code'] = $Mortgage->ThirdConcurrent->companyCode;
                                    if (isset($Mortgage->ThirdConcurrent->date))
                                        $SHArray['tc_date'] = $Mortgage->ThirdConcurrent->date;
                                    if (isset($Mortgage->ThirdConcurrent->interestRate))
                                        $SHArray['tc_interest_rate'] = $Mortgage->ThirdConcurrent->interestRate;
                                    if (isset($Mortgage->ThirdConcurrent->loanTypeCode))
                                        $SHArray['tc_loan_type_code'] = $Mortgage->ThirdConcurrent->loanTypeCode;
                                    if (isset($Mortgage->ThirdConcurrent->term))
                                        $SHArray['tc_term'] = $Mortgage->ThirdConcurrent->term;
                                    if (isset($Mortgage->ThirdConcurrent->dueDate))
                                        $SHArray['tc_due_date'] = $Mortgage->ThirdConcurrent->dueDate;
                                    if (isset($Mortgage->ThirdConcurrent->interestRateType))
                                        $SHArray['tc_interest_rate_type'] = $Mortgage->ThirdConcurrent->interestRateType;
                                    if (isset($Mortgage->ThirdConcurrent->equityFlag))
                                        $SHArray['tc_equity_flag'] = $Mortgage->ThirdConcurrent->equityFlag;
                                    if (isset($Mortgage->ThirdConcurrent->interestMargin))
                                        $SHArray['tc_interest_margin'] = $Mortgage->ThirdConcurrent->interestMargin;
                                    if (isset($Mortgage->ThirdConcurrent->mortgageInterestIndex))
                                        $SHArray['tc_mortgage_interest_index'] = $Mortgage->ThirdConcurrent->mortgageInterestIndex;
                                    if (isset($Mortgage->ThirdConcurrent->mortgageInterestRateMax))
                                        $SHArray['tc_mortgage_interest_rate_max'] = $Mortgage->ThirdConcurrent->mortgageInterestRateMax;
                                }
                            }

                            $SHArray = array_merge($SHArray, $PropIdentity);
                            if (count((array)$SHArray)) {
                                $Res[] = $SHArray;
                            }
                        }
                    }
                }
            }
        }
        return $Res;
    }    

    private static function ParseExtendedData($Data)
    {
        // echo 'Data :: <pre>';
        // print_r($Data);
        /* //exit; */
        // echo '<hr>';
        $Res = array();
        if (isset($Data->status) 
            && isset($Data->status->msg) 
            && $Data->status->msg == 'SuccessWithResult') {
            if (isset($Data->property) && count((array)$Data->property)) {
                $Property = $Data->property[0];
                if (isset($Property->identifier) && !empty($Property->identifier)) {
                    if (isset($Property->identifier->obPropId))
                        $Res['ob_prop_id'] = $Property->identifier->obPropId;
                    if (isset($Property->identifier->fips))    
                        $Res['fips'] = $Property->identifier->fips;
                    if (isset($Property->identifier->apn))
                        $Res['apn'] = $Property->identifier->apn;
                    if (isset($Property->identifier->attomId))
                        $Res['attom_id'] = $Property->identifier->attomId;
                }
                // echo 'Res->identifier :: <pre>';
                // print_r($Res);
                // echo '<hr>';
                if (isset($Property->lot) && count((array)$Property->lot)) {
                    if (isset($Property->lot->depth))
                        $Res['lot_depth'] = $Property->lot->depth;
                    if (isset($Property->lot->frontage))
                        $Res['lot_frontage'] = $Property->lot->frontage;
                    if (isset($Property->lot->lotNum))
                        $Res['lot_num'] = $Property->lot->lotNum;
                    
                    if (isset($Property->lot->lotSize1))
                        $Res['lot_size1'] = $Property->lot->lotSize1;
                    if (isset($Property->lot->lotSize2))
                        $Res['lot_size2'] = $Property->lot->lotSize2;

                    if (isset($Property->lot->lotsize1))
                        $Res['lot_size1'] = $Property->lot->lotsize1;
                    if (isset($Property->lot->lotsize2))
                        $Res['lot_size2'] = $Property->lot->lotsize2;

                    if (isset($Property->lot->zoningType))
                        $Res['lot_zoning_type'] = $Property->lot->zoningType;
                    if (isset($Property->lot->siteZoningIdent))
                        $Res['lot_site_zoning_ident'] = $Property->lot->siteZoningIdent;
                }
                // echo 'Res->lot :: <pre>';
                // print_r($Res);
                // echo '<hr>';
                if (isset($Property->area) && count((array)$Property->area)) {
                    if (isset($Property->area->blockNum))
                        $Res['area_block_num'] = $Property->area->blockNum;
                    if (isset($Property->area->countrySecSubd))
                        $Res['area_country_sec_subd'] = $Property->area->countrySecSubd;
                    if (isset($Property->area->countyUse1))
                        $Res['area_county_use1'] = $Property->area->countyUse1;
                    if (isset($Property->area->munCode))
                        $Res['area_mun_code'] = $Property->area->munCode;
                    if (isset($Property->area->munName))
                        $Res['area_mun_name'] = $Property->area->munName;
                    if (isset($Property->area->srvyRange))
                        $Res['area_srvy_range'] = $Property->area->srvyRange;
                    if (isset($Property->area->srvySection))
                        $Res['area_srvy_section'] = $Property->area->srvySection;
                    if (isset($Property->area->srvyTownship))
                        $Res['area_srvy_township'] = $Property->area->srvyTownship;
                    if (isset($Property->area->subdName))
                        $Res['area_subd_name'] = $Property->area->subdName;
                    if (isset($Property->area->subdTractNum))
                        $Res['area_subd_tract_num'] = $Property->area->subdTractNum;
                    if (isset($Property->area->taxCodeArea))
                        $Res['tax_code_area'] = $Property->area->taxCodeArea;
                    if (isset($Property->area->censusTractIdent))
                        $Res['census_tract_ident'] = $Property->area->censusTractIdent;
                    if (isset($Property->area->censusBlockGroup))
                        $Res['census_block_group'] = $Property->area->censusBlockGroup;
                }

                if (isset($Property->address) && count((array)$Property->address)) {
                    if (isset($Property->address->country))
                        $Res['address_country'] = $Property->address->country;
                    if (isset($Property->address->countrySubd))
                        $Res['address_country_subd'] = $Property->address->countrySubd;
                    if (isset($Property->address->line1))
                        $Res['address_line1'] = $Property->address->line1;
                    if (isset($Property->address->line2))
                        $Res['address_line2'] = $Property->address->line2;
                    if (isset($Property->address->locality))
                        $Res['address_locality'] = $Property->address->locality;
                    if (isset($Property->address->matchCode))
                        $Res['address_match_code'] = $Property->address->matchCode;
                    if (isset($Property->address->oneLine))
                        $Res['address_one_line'] = $Property->address->oneLine;
                    if (isset($Property->address->postal1))
                        $Res['address_postal1'] = $Property->address->postal1;
                    if (isset($Property->address->postal2))
                        $Res['address_postal2'] = $Property->address->postal2;
                    if (isset($Property->address->postal3))
                        $Res['address_postal3'] = $Property->address->postal3;
                    if (isset($Property->address->stateFips))
                        $Res['address_state_fips'] = $Property->address->stateFips;
                }

                if (isset($Property->location) && count((array)$Property->location)) {
                    if (isset($Property->location->accuracy))
                        $Res['location_accuracy'] = $Property->location->accuracy;
                    if (isset($Property->location->elevation))
                        $Res['location_elevation'] = $Property->location->elevation;
                    if (isset($Property->location->latitude))
                        $Res['location_latitude'] = $Property->location->latitude;
                    if (isset($Property->location->longitude))
                        $Res['location_longitude'] = $Property->location->longitude;
                    if (isset($Property->location->distance))
                        $Res['location_distance'] = $Property->location->distance;
                    if (isset($Property->location->geoid))
                        $Res['location_geoid'] = $Property->location->geoid;
                    if (isset($Property->location->geoIdV4))
                        $Res['location_geoidv4'] = json_encode($Property->location->geoIdV4);    
                }

                if (isset($Property->summary) && count((array)$Property->summary)) {
                    if (isset($Property->summary->absenteeInd))
                        $Res['summary_absentee_ind'] = $Property->summary->absenteeInd;
                    if (isset($Property->summary->propClass))
                        $Res['summary_prop_class'] = $Property->summary->propClass;
                    if (isset($Property->summary->propSubType))
                        $Res['summary_prop_sub_type'] = $Property->summary->propSubType;
                    if (isset($Property->summary->propType))
                        $Res['summary_prop_type'] = $Property->summary->propType;
                    if (isset($Property->summary->yearBuilt))
                        $Res['summary_year_built'] = $Property->summary->yearBuilt;
                    if (isset($Property->summary->propLandUse))
                        $Res['summary_prop_land_use'] = $Property->summary->propLandUse;
                    if (isset($Property->summary->propIndicator))
                        $Res['summary_prop_indicator'] = $Property->summary->propIndicator;
                    if (isset($Property->summary->quitClaimFlag))
                        $Res['summary_quit_claim_flag'] = $Property->summary->quitClaimFlag;
                    if (isset($Property->summary->REOflag))
                        $Res['summary_reo_flag'] = $Property->summary->REOflag;
                }

                if (isset($Property->utilities) && count((array)$Property->utilities)) {
                    if (isset($Property->utilities->heatingType))
                        $Res['heating_type'] = $Property->utilities->heatingType;
                    if (isset($Property->utilities->wallType))
                        $Res['wall_type'] = $Property->utilities->wallType;
                }

                if (isset($Property->building) && count((array)$Property->building)) {
                    $Building = $Property->building;
                    if (isset($Building->size) && count((array)$Building->size)) {
                        if (isset($Building->size->bldgSize))
                            $Res['bldg_size'] = $Building->size->bldgSize;
                        if (isset($Building->size->bldgsize))
                            $Res['bldg_size'] = $Building->size->bldgsize;

                        if (isset($Building->size->grossSize))    
                            $Res['gross_size'] = $Building->size->grossSize;
                        if (isset($Building->size->grosssize))    
                            $Res['gross_size'] = $Building->size->grosssize;

                        if (isset($Building->size->grossSizeAdjusted))                            
                            $Res['gross_size_adjusted'] = $Building->size->grossSizeAdjusted;
                        if (isset($Building->size->grosssizeadjusted))                            
                            $Res['gross_size_adjusted'] = $Building->size->grosssizeadjusted;

                        if (isset($Building->size->groundFloorSize))
                            $Res['ground_floor_size'] = $Building->size->groundFloorSize;
                        if (isset($Building->size->groundfloorsize))
                            $Res['ground_floor_size'] = $Building->size->groundfloorsize;

                        if (isset($Building->size->livingSize))
                            $Res['living_size'] = $Building->size->livingSize;
                        if (isset($Building->size->livingsize))
                            $Res['living_size'] = $Building->size->livingsize;

                        if (isset($Building->size->sizeInd))
                            $Res['size_ind'] = $Building->size->sizeInd;

                        if (isset($Building->size->universalSize))
                            $Res['universal_size'] = $Building->size->universalSize;
                        if (isset($Building->size->universalsize))
                            $Res['universal_size'] = $Building->size->universalsize;

                        if (isset($Building->size->atticSize))
                            $Res['attic_size'] = $Building->size->atticSize;
                    }

                    if (isset($Building->rooms) && count((array)$Building->rooms)) {
                        if (isset($Building->rooms->bathFixtures))
                            $Res['bath_fixtures'] = $Building->rooms->bathFixtures;
                        if (isset($Building->rooms->baths1qtr))
                            $Res['baths1qtr'] = $Building->rooms->baths1qtr;
                        if (isset($Building->rooms->baths3qtr))
                            $Res['baths3qtr'] = $Building->rooms->baths3qtr;
                        if (isset($Building->rooms->bathsCalc))
                            $Res['baths_calc'] = $Building->rooms->bathsCalc;
                        if (isset($Building->rooms->bathsFull))
                            $Res['baths_full'] = $Building->rooms->bathsFull;
                        if (isset($Building->rooms->bathsHalf))
                            $Res['baths_half'] = $Building->rooms->bathsHalf;
                        
                        if (isset($Building->rooms->bathsTotal))
                            $Res['baths_total'] = $Building->rooms->bathsTotal;
                        if (isset($Building->rooms->bathstotal))
                            $Res['baths_total'] = $Building->rooms->bathstotal;

                        if (isset($Building->rooms->beds))
                            $Res['beds'] = $Building->rooms->beds;
                        if (isset($Building->rooms->roomsTotal))
                            $Res['rooms_total'] = $Building->rooms->roomsTotal;
                    }

                    if (isset($Building->interior) && count((array)$Building->interior)) {
                        if (isset($Building->interior->bsmtSize))
                            $Res['bsmt_size'] = $Building->interior->bsmtSize;
                        if (isset($Building->interior->bsmtType))
                            $Res['bsmt_type'] = $Building->interior->bsmtType;
                        if (isset($Building->interior->bsmtFinishedPercent))
                            $Res['bsmt_finished_percent'] = $Building->interior->bsmtFinishedPercent;
                        if (isset($Building->interior->fplcCount))
                            $Res['fplc_count'] = $Building->interior->fplcCount;
                        if (isset($Building->interior->fplcInd))
                            $Res['fplc_ind'] = $Building->interior->fplcInd;
                        if (isset($Building->interior->fplcType))
                            $Res['fplc_type'] = $Building->interior->fplcType;
                    }

                    if (isset($Building->construction) && count((array)$Building->construction)) {
                        if (isset($Building->construction->condition))
                            $Res['construction_condition'] = $Building->construction->condition;
                        if (isset($Building->construction->frameType))
                            $Res['construction_frame_type'] = $Building->construction->frameType;
                        if (isset($Building->construction->wallType))
                            $Res['construction_wall_type'] = $Building->construction->wallType;
                        if (isset($Building->construction->propertyStructureMajorImprovementsYear))
                            $Res['property_structure_majorImprovements_year'] = $Building->construction->propertyStructureMajorImprovementsYear;
                    }

                    if (isset($Building->parking) && count((array)$Building->parking)) {
                        if (isset($Building->parking->garageType))
                            $Res['garage_type'] = $Building->parking->garageType;
                        if (isset($Building->parking->prkgSize))
                            $Res['prkg_size'] = $Building->parking->prkgSize;
                        if (isset($Building->parking->prkgSpaces))
                            $Res['prkg_spaces'] = $Building->parking->prkgSpaces;
                        if (isset($Building->parking->prkgType))
                            $Res['prkg_type'] = $Building->parking->prkgType;
                    }

                    if (isset($Building->summary) && count((array)$Building->summary)) {
                        if (isset($Building->summary->levels))
                            $Res['summary_levels'] = $Building->summary->levels;
                        if (isset($Building->summary->storyDesc))
                            $Res['summary_story_desc'] = $Building->summary->storyDesc;
                        if (isset($Building->summary->unitsCount))
                            $Res['summary_units_count'] = $Building->summary->unitsCount;
                        if (isset($Building->summary->viewCode))
                            $Res['summary_view_code'] = $Building->summary->viewCode;
                    }
                }

                if (isset($Property->assessment) && count((array)$Property->assessment)) {
                    $Assessment = $Property->assessment;
                    if (isset($Assessment->appraised) && count((array)$Assessment->appraised)) {
                        if (isset($Assessment->appraised->apprImprValue))
                            $Res['appr_impr_value'] = $Assessment->appraised->apprImprValue;
                        if (isset($Assessment->appraised->apprLandValue))
                            $Res['appr_land_value'] = $Assessment->appraised->apprLandValue;
                        if (isset($Assessment->appraised->apprTtlValue))
                            $Res['appr_ttl_value'] = $Assessment->appraised->apprTtlValue;
                    }

                    if (isset($Assessment->assessed) && count((array)$Assessment->assessed)) {
                        if (isset($Assessment->assessed->assdImprValue))
                            $Res['assd_impr_value'] = $Assessment->assessed->assdImprValue;
                        if (isset($Assessment->assessed->assdLandValue))
                            $Res['assd_land_value'] = $Assessment->assessed->assdLandValue;
                        if (isset($Assessment->assessed->assdTtlValue))
                            $Res['assd_ttl_value'] = $Assessment->assessed->assdTtlValue;
                    }

                    if (isset($Assessment->market) && count((array)$Assessment->market)) {
                        if (isset($Assessment->market->mktImprValue))
                            $Res['mkt_impr_value'] = $Assessment->market->mktImprValue;
                        if (isset($Assessment->market->mktLandValue))
                            $Res['mkt_land_value'] = $Assessment->market->mktLandValue;
                        if (isset($Assessment->market->mktTtlValue))
                            $Res['mkt_ttl_value'] = $Assessment->market->mktTtlValue;
                    }

                    if (isset($Assessment->tax) && count((array)$Assessment->tax)) {
                        if (isset($Assessment->tax->taxAmt))
                            $Res['tax_amt'] = $Assessment->tax->taxAmt;
                        if (isset($Assessment->tax->taxPerSizeUnit))
                            $Res['tax_per_size_unit'] = $Assessment->tax->taxPerSizeUnit;
                        if (isset($Assessment->tax->taxYear))
                            $Res['tax_year'] = $Assessment->tax->taxYear;

                        if (isset($Assessment->tax->exemption) && count((array)$Assessment->tax->exemption)) {
                            if (isset($Assessment->tax->exemption->ExemptionAmount1))
                                $Res['exemption_amount1'] = $Assessment->tax->exemption->ExemptionAmount1;
                            if (isset($Assessment->tax->exemption->ExemptionAmount2))
                                $Res['exemption_amount2'] = $Assessment->tax->exemption->ExemptionAmount2;
                            if (isset($Assessment->tax->exemption->ExemptionAmount3))
                                $Res['exemption_amount3'] = $Assessment->tax->exemption->ExemptionAmount3;
                            if (isset($Assessment->tax->exemption->ExemptionAmount4))
                                $Res['exemption_amount4'] = $Assessment->tax->exemption->ExemptionAmount4;
                            if (isset($Assessment->tax->exemption->ExemptionAmount5))
                                $Res['exemption_amount5'] = $Assessment->tax->exemption->ExemptionAmount5;
                        }
                    }

                    if (isset($Assessment->delinquentyear))
                        $Res['delinquentyear'] = $Assessment->delinquentyear;
                    if (isset($Assessment->improvementPercent))
                        $Res['improvement_percent'] = $Assessment->improvementPercent;
                    if (isset($Assessment->fullCashValue))
                        $Res['full_cash_value'] = $Assessment->fullCashValue;    
                }
            }
        }
        return $Res;
    }
    
    private static function CheckATOMTable($TableName, $InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array($TableName));
        $Obj->AddFlds(array('insights_property_id', 'id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        return $Obj->GetSingle();
    }
    private static function UpdateATOMTable($TableName, $Row, $ID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array($TableName));
        $Obj->AddInsrtFlds($Row);
        $Obj->AddFldCond('id', $ID);
        return $Obj->Update();
    }
    
    private static function InsertATOMTable($TableName, $Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array($TableName));
        $Obj->AddInsrtFlds($Row);
        return $Obj->InsertSingle();
    }
    
    private static function UpdateInsightsMain($Data, $InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_main'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->Update();
    }
    
    private static function FormAddressString($Property)
    {
        // Added if condition to check address2 data in tbl_insights_address_usps table 
        // then use that address.
        $USPSData = self::GetUSPS($Property['insights_property_id']);
        
        if($USPSData && ($USPSData["address2"] || $USPSData["address2"] != null || $USPSData["address2"] != '')){
            $Address2 = $USPSData['city'].', '.$USPSData['state'].' '.$USPSData['zip5'];

            $Address1 = trim($USPSData['address2']);

        }else{
            $Address2 = $Property['property_city'].', '.$Property['property_state'].' '.$Property['property_zipcode'];
    
            if (isset($Property['unit_number']) && trim($Property['unit_number']) != '')
                $Address1 = trim(trim($Property['property_address']).' '.trim($Property['unit_number']));
            else
                $Address1 = trim($Property['property_address']);
        }

        return 'address1='.urlencode($Address1).'&address2='.urlencode(trim($Address2));
    }
    
    private static function UpdateOrInsertInsightIssues($InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_issues'));
        $Obj->AddFlds(array('id'));
        $Obj->AddTblCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('issue_description', 'Address Not Found In Public Data');
        $Obj->AddFldCond('issues_present','Y');
        $issueData = $Obj->GetSingle();

        if(!$issueData){
            $Issues = array(
                'insights_property_id' => $InsightsPropertyID,
                'issues_present' => 'Y',
                'issue_description' => 'Address Not Found In Public Data',
                'issue_found_date' => date(DB_DATETIME_FORMAT),
                'is_mandatory_for_home_value' => 'N',
                'modified_date' => date(DB_DATETIME_FORMAT),
                'modified_by_user' => 0
            );

            SIFlagIssues::InsertIssue($Issues);
        }
    }
    private static function GetUSPS($ID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_address_usps'));
        $Obj->AddFlds(array('insights_property_id','address2','city','state','zip5'));
        $Obj->AddFldCond('insights_property_id', $ID);
        return $Obj->GetSingle();
    }
    
    private static function UpdateFetchedStatus($Field, $InsightsPropertyID, $Flag = 'Y')
    {
        $Row = array();
        $Row[$Field] = $Flag;
        self::UpdateInsightsMain($Row, $InsightsPropertyID);
    }

   



}
?>