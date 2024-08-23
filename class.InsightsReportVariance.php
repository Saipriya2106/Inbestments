<?php 
class InsightsReportVariance{
    public static function CallHomeValueVariance($HomeValueVarianceActive)
    {
        $HomeValueCompareDifference = 4;
        if($HomeValueVarianceActive)
        {
  
            $VarianceCondition = Common::GetSettingValues('INSIGHTS_REPORT_VARIANCE_CONDITION');
            $HomeValueAdjustment = Common::GetSettingValues('HomeValue_Adjustment_Percent');
            $HomeValueAdjustmentPercent=$HomeValueAdjustment['option_value'];

            $VarianceCompareData = array();
            $n=0;        
            $Condition=" AND ep.pcomp_criteria_id !=12100 ";
            $HavingCondition="HAVING  `State` = 'WA' AND `Variance_Percent` >=".$HomeValueAdjustmentPercent." OR `Variance_Percent` < 0 ";
            $GetCurrentMonthPropertiesForVariance = self::GetVarianceQueryData(CURRENT_MONTH, CURRENT_YEAR, $Condition, $HavingCondition,'',CONFIG_IS_CURRENT_MONTH_VARIANCE_COMPLETED );
            echo "<br>#1 GetCurrentMonthPropertiesForVariance::<br><pre>";
            print_r($GetCurrentMonthPropertiesForVariance);
        
            if(!empty($GetCurrentMonthPropertiesForVariance)){
                foreach($GetCurrentMonthPropertiesForVariance as $PropertyItem) {
            
                    $Parms = array('cron_function_name' => CONFIG_IS_CURRENT_MONTH_VARIANCE_COMPLETED, 'insights_property_id' => $PropertyItem['insights_property_id'], 
                    'cron_function_status_flag' => 'Y','tp_api'=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR ); 
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                    
                    $Parms = array('send_email' =>'Y','record_status' => 'A'); 
                    $UpdateMappedPropertiesWithInbestments=Common::UpdateInsightsMainTable($PropertyItem['insights_property_id'], $Parms,false);   
                    
                    $VarianceCompareData[$n]['insights_property_id'] =$PropertyItem['insights_property_id']; 
                    $VarianceCompareData[$n]['est_month'] =$PropertyItem['est_month']; 
                    $VarianceCompareData[$n]['est_year'] =$PropertyItem['est_year']; 
                    $VarianceCompareData[$n]['current_month_home_value'] =$PropertyItem['Home_Value']; 
                    $VarianceCompareData[$n]['current_external_home_value'] =$PropertyItem['External_Home_Value']; 
                    $VarianceCompareData[$n]['current_pcomp_criteria_id'] =$PropertyItem['pcomp_criteria_id']; 
                    $VarianceCompareData[$n]['property_address'] =$PropertyItem['Address']; 
                    $VarianceCompareData[$n]['unit_number'] =$PropertyItem['Unit_Number']; 
                    $VarianceCompareData[$n]['property_city'] =$PropertyItem['City']; 
                    $VarianceCompareData[$n]['property_zipcode'] =$PropertyItem['Zip_Code']; 
                    $VarianceCompareData[$n]['property_state'] =$PropertyItem['State']; 
                    $VarianceCompareData[$n]['comp_properties'] =$PropertyItem['comp_properties']; 
                    $VarianceCompareData[$n]['criteria'] =$PropertyItem['criteria']; 

    
                    $HomeValue= (double)$PropertyItem['Home_Value']; 
                    $ExternalHomeValue = (double)$PropertyItem['External_Home_Value'];
                    if($HomeValue!='' && $ExternalHomeValue!='') 
                    {
                
                        $HomeValueDifference=($HomeValue-$ExternalHomeValue)/$ExternalHomeValue;
                        $HomeValueDifferencePercent = round((float)$HomeValueDifference * 100 ,2);
                        echo 'Home-Value:: '.$HomeValue." :: ".$ExternalHomeValue." :: ".$HomeValueDifference." :: ".$HomeValueDifferencePercent;
                    
                        $VarianceCompareData[$n]['variance'] = $HomeValueDifference;
                        $VarianceCompareData[$n]['Variance_Percent'] = $HomeValueDifferencePercent ;
                        $VarianceDifference = false;
                        if($HomeValueDifferencePercent>=$HomeValueCompareDifference){
                            echo "<br> Above :: ".$PropertyItem['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                            $VarianceDifference = true;
                        } else if($HomeValueDifferencePercent < 0 ){
                            echo "<br> Below ::".$PropertyItem['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                            $VarianceDifference = true;
                        }
                        if($VarianceDifference)
                        {
                            $AdjustHomeValues=array();
    
                            $AdjustHomeValues['est_price']=$PropertyItem['External_Home_Value']; 
                            $AdjustHomeValues['high_est_price']=$PropertyItem['high_est_price'];
                            $AdjustHomeValues['low_est_price']=$PropertyItem['low_est_price'];
                            $AdjustHomeValues['home_value_adjust_percent']=1; 
        
                            $NewHomeValues = self::AdjustHomeValue($AdjustHomeValues);
                                
                            $VarianceCompareData[$n]['new_est_price']=$NewHomeValues['NewEstPrice'];
                            $VarianceCompareData[$n]['new_high_est_price']=$NewHomeValues['NewHighEstPrice'];
                            $VarianceCompareData[$n]['new_low_est_price']=$NewHomeValues['NewLowEstPrice']; 
    
                            $CurrentHomeValueDifference = ( (double)$VarianceCompareData[$n]['new_est_price']/ (double)$AdjustHomeValues['est_price']); 
                            $CurrentHomeValueDifferencePercent = round((float)$CurrentHomeValueDifference  ,2);
                            $VarianceCompareData[$n]['current_home_value_differnce'] =$CurrentHomeValueDifferencePercent;
                            $VarianceCompareData[$n]['previous_month_available'] =0;
                            $VarianceCompareData[$n]['pcomp_criteria_id'] =12100;
    
                            $InsertNewHomeValue = self::InsertAdjustedNewHomeValue($VarianceCompareData[$n],CONFIG_VARIANCE_2);
                            echo 'Current Month Variance Send Mail #1 <br>';
                            $UpdateSendMailStatus = Common::UpdateSendMailStatus($PropertyItem['insights_property_id'], SEND_MONTHLY_REPORT, 'Y'); 
                                                        
                    
                        }else{
                            echo "<br>Differnce In Current Moth :: ".$PropertyItem['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                            $SendReportParam = array(
                                'cron_function_name' => CONFIG_SEND_MONTHY_REPORT, 
                                'insights_property_id' => $PropertyItem['insights_property_id'], 
                                'cron_function_status_flag' =>'Yes',  
                                'home_value_diff'=>$HomeValueDifferencePercent,
                                'month' =>CURRENT_MONTH, 
                                'year' =>CURRENT_YEAR ); 
                            $SendReportStatus = Common::InsertUpdateCronProcessStatusFlag($SendReportParam );
              
                            echo 'Current Month Variance Send Mail #2 <br>';  
                            $UpdateSendMailStatus = Common::UpdateSendMailStatus($PropertyItem['insights_property_id'], SEND_MONTHLY_REPORT, 'Y');                            
                        }                    
                    }  
                    
                }
    
            }else{
     
                $VarianceCompareData = array();
     
                $Condition="  AND ep.pcomp_criteria_id != 12200 AND ep.pcomp_criteria_id != 12300  ";
                $HavingCondition=" HAVING  `State` = 'WA'";
                $GetCurrentMonthProperties = self::GetVarianceQueryData(CURRENT_MONTH, CURRENT_YEAR, $Condition, $HavingCondition,CONFIG_IS_CURRENT_MONTH_VARIANCE_COMPLETED,CONFIG_IS_PREV_MONTH_VARIANCE_COMPLETED);
                $GetPreviouseMonthProperties = self::GetVarianceQueryData(PREVIOUS_MONTH, PREVIOUS_YEAR, $Condition, $HavingCondition,CONFIG_IS_CURRENT_MONTH_VARIANCE_COMPLETED,CONFIG_IS_PREV_MONTH_VARIANCE_COMPLETED);
              
                echo "GetCurrentMonthProperties::<pre>";
                print_r($GetCurrentMonthProperties);
                
                echo "GetPreviouseMonthProperties::<pre>";
                print_r($GetPreviouseMonthProperties);
                
                $VarianceCompareData = array();
                $n=0;
                if(!empty($GetCurrentMonthProperties)){
      
                    foreach($GetCurrentMonthProperties as $Property) {
    
                      
                        $Parms = array('cron_function_name' => CONFIG_IS_PREV_MONTH_VARIANCE_COMPLETED, 'insights_property_id' => $Property['insights_property_id'], 
                        'cron_function_status_flag' => 'Y','tp_api'=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
    
                        $VarianceCompareData[$n]['insights_property_id'] =$Property['insights_property_id']; 
                        $VarianceCompareData[$n]['est_month'] =$Property['est_month']; 
                        $VarianceCompareData[$n]['est_year'] =$Property['est_year']; 
                        $VarianceCompareData[$n]['current_month_home_value'] =$Property['Home_Value']; 
                        $VarianceCompareData[$n]['current_external_home_value'] =$Property['External_Home_Value']; 
                        $VarianceCompareData[$n]['current_pcomp_criteria_id'] =$Property['pcomp_criteria_id']; 
                        $VarianceCompareData[$n]['property_address'] =$Property['Address']; 
                        $VarianceCompareData[$n]['unit_number'] =$Property['Unit_Number']; 
                        $VarianceCompareData[$n]['property_city'] =$Property['City']; 
                        $VarianceCompareData[$n]['property_zipcode'] =$Property['Zip_Code']; 
                        $VarianceCompareData[$n]['property_state'] =$Property['State']; 
                        $VarianceCompareData[$n]['comp_properties'] =$Property['comp_properties']; 
                        $VarianceCompareData[$n]['criteria'] =$Property['criteria']; 

                        $PreviousMonthData=false;
                        foreach($GetPreviouseMonthProperties as $PrevProperty){
                            if($PrevProperty['insights_property_id']==$Property['insights_property_id'] && $PrevProperty['est_month']!='' && $PrevProperty['Home_Value']!='' && !$PrevProperty['Home_Value'] ){
                                $PreviousMonthData=true;
                                $PrevMonthInsightsPropertyId=$PrevProperty['insights_property_id'];
                           
                            }
                        }
                   
                        echo $Property['insights_property_id'].' :: '.' n:: '.$n.' :: '.$PreviousMonthData.'<br>';
                        if($PreviousMonthData){
                        
                            $b = array_map(function($element){return $element['insights_property_id'];}, $GetPreviouseMonthProperties);
                           
                            $GetPrevMonthIndex = array_search($Property['insights_property_id'], array_column($GetPreviouseMonthProperties, 'insights_property_id'));                 
                           
                        
                            $PreviousMonthProperty = $GetPreviouseMonthProperties[$GetPrevMonthIndex];
                            echo 'PreviousMonthProperty::<pre>';
                            print_r($PreviousMonthProperty);         
                            
                            $PreviousMonthProperty = $GetPreviouseMonthProperties[$n];
                            $PrevMonthHomeValue[$n]=$Property['insights_property_id']; 
                            $PreviousMonthHomeValue=$PreviousMonthProperty['Home_Value'];
                            $PreviousMonthHighEstPrice=$PreviousMonthProperty['high_est_price'];
                            $PreviousMonthLowPrice=$PreviousMonthProperty['low_est_price'];
                            $VarianceCompareData[$n]['previous_month_home_value'] =$PreviousMonthProperty['Home_Value']; 
                            $VarianceCompareData[$n]['previous_external_home_value'] =$PreviousMonthProperty['External_Home_Value']; 
                            $VarianceCompareData[$n]['previous_pcomp_criteria_id'] =$PreviousMonthProperty['pcomp_criteria_id']; 
                            $VarianceCompareData[$n]['home_value'] = (double)$Property['Home_Value'] - (double)$PreviousMonthHomeValue;
                            $VarianceCompareData[$n]['external_value'] = (double)$Property['External_Home_Value'] - (double)$PreviousMonthProperty['External_Home_Value']; 
                            $VarianceCompareData[$n]['compare_pcomp_criteria_id'] = (double)($Property['pcomp_criteria_id']= (double)$PreviousMonthProperty['pcomp_criteria_id'])? "Yes" : "No"; 
                        
                            if($VarianceCompareData[$n]['home_value']!='' ) 
                            {
    
                                $CurrentMonthHomeValue=($VarianceCompareData[$n]['home_value']!='')?(double)$VarianceCompareData[$n]['home_value'] : 0;
                                $CurrentMonthExternalHomeValue=($VarianceCompareData[$n]['external_value']!='')?(double)$VarianceCompareData[$n]['external_value'] : 0;
                                
                                $PreviousMonthHomeValue=($PreviousMonthProperty['Home_Value']!='')?(double)$PreviousMonthProperty['Home_Value'] : 0;
                                $PreviousMonthExternalHomeValue=($PreviousMonthProperty['External_Home_Value']!='')?(double)$PreviousMonthProperty['External_Home_Value'] : 0;
    
                                if($PreviousMonthProperty['pcomp_criteria_id']==13000){
                                    if($CurrentMonthHomeValue < $PreviousMonthHomeValue){
                           
                                    }
                                }
    
                                $HomeValueDifference = ( $CurrentMonthHomeValue /  $PreviousMonthHomeValue);
                                $HomeValueDifferencePercent = round((float)$HomeValueDifference * 100 ,2);
                                $VarianceCompareData[$n]['home_value_differnce'] =$HomeValueDifferencePercent;
                                
                              
                                echo 'insights_property_id :: '.$Property['insights_property_id']. ' :: Home-Value:: '.$CurrentMonthHomeValue." :: ".$PreviousMonthHomeValue." :: ".$HomeValueDifference." :: ".$HomeValueDifferencePercent;
    
                                $VarianceDifference = false;
                                if($HomeValueDifferencePercent>=$HomeValueCompareDifference){
                                    echo "<br>Differnce Above :: ".$Property['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                                    $VarianceDifference = true;
                                    
                                } else if($HomeValueDifferencePercent < 0 ){
                                
                                    echo "<br>Differnce Below ::".$Property['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                                    $VarianceDifference = true;
                                }else{
                                    echo "<br>Differnce in Previous Month :: ".$Property['insights_property_id']." :: ".$HomeValueDifferencePercent." :: "."<br>";
                                    $SendReportParam = array(
                                        'cron_function_name' => CONFIG_SEND_MONTHY_REPORT, 
                                        'insights_property_id' => $Property['insights_property_id'], 
                                        'cron_function_status_flag' =>'Yes',  
                                        'home_value_diff'=>$HomeValueDifferencePercent,
                                        'month' =>CURRENT_MONTH, 
                                        'year' =>CURRENT_YEAR ); 
                                    $SendReportStatus = Common::InsertUpdateCronProcessStatusFlag($SendReportParam );
                       
                                    echo 'Privious Month Variance Send Mail #1 <br>';
                                    $UpdateSendMailStatus = Common::UpdateSendMailStatus($Property['insights_property_id'], SEND_MONTHLY_REPORT, 'Y'); 
                                }
                                
                                if($VarianceDifference)
                                {
                                    $AdjustHomeValues=array();
                                    $AdjustHomeValues['est_price']=$PreviousMonthHomeValue; 
                                    $AdjustHomeValues['high_est_price']=$PreviousMonthHighEstPrice; 
                                    $AdjustHomeValues['low_est_price']=$PreviousMonthLowPrice; 
                                    $AdjustHomeValues['home_value_adjust_percent']=1; 
                               
                                    $NewHomeValues = self::AdjustHomeValue($AdjustHomeValues);
                                        
                                    $VarianceCompareData[$n]['new_est_price']=$NewHomeValues['NewEstPrice'];
                                    $VarianceCompareData[$n]['new_high_est_price']=$NewHomeValues['NewHighEstPrice'];
                                    $VarianceCompareData[$n]['new_low_est_price']=$NewHomeValues['NewLowEstPrice']; 
    
                                    $CurrentHomeValueDifference = ( (double)$VarianceCompareData[$n]['new_est_price']/ (double)$PreviousMonthProperty['Home_Value']);
                                    $CurrentHomeValueDifferencePercent = round((float)$CurrentHomeValueDifference  ,2);
                                    $VarianceCompareData[$n]['current_home_value_differnce'] =$CurrentHomeValueDifferencePercent;
                                    $VarianceCompareData[$n]['previous_month_available'] =1;
                                    $VarianceCompareData[$n]['pcomp_criteria_id'] =12200;
                                    
                                    $InsertNewHomeValue = self::InsertAdjustedNewHomeValue($VarianceCompareData[$n],CONFIG_VARIANCE_3);
                                    echo "VarianceCompareData #1.1 ::<pre>";
                       
                                    echo 'Previous Month Variance Send Mail #2 <br>';
                                    $UpdateSendMailStatus = Common::UpdateSendMailStatus($Property['insights_property_id'], SEND_MONTHLY_REPORT, 'Y');                                                   
           
                                }
                            }
                  
                                                
                        }else {
                            echo '<br>LATEST PROPERTIES <br>';
    
                            echo $Property['insights_property_id'].' :: '.' n:: '.$n.' :: '.$PreviousMonthData.' Noooo<br>';
                            $HomeValue= (double)$Property['Home_Value']; 
                            $ExternalHomeValue = (double)$Property['External_Home_Value'];
                                
                        }
                        echo '<hr><br>';
                        $n++; 
                    }
                }
    
                echo "<br>VarianceCompareData  #2  ::<pre>";
              //  print_r($VarianceCompareData);
            }
        }            
    }
    public static function GetVarianceQueryData($month, $year, $queryCondition, $HavingCondition,$ConfigIn,$ConfigNotIn)
        {
            $Obj = new SqlManager();
            $query = " SELECT 
            im.guid, im.insights_property_id, im.property_address `Address`, im.unit_number `Unit_Number`, im.property_city `City`, im.property_state `State`, 
            im.property_zipcode `Zip_Code`, 
            ep.id `ep_id`, ep.est_price `Home_Value`, ee.est_price `External_Home_Value`, 
            (ep.est_price - ee.est_price) `Variance`, 
            ((ep.est_price - ee.est_price)/ee.est_price)*100 `Variance_Percent`, ep.pcomp_criteria_id, 
            ep.high_est_price, ep.low_est_price,ep.est_month, ep.est_year,ep.comp_properties, ep.criteria,
            im.agent_id, im.lender_id, mls.status,  im.record_status, ep.is_best, 
            isms.send_mail
            FROM insights_main im 
            JOIN insights_property_contact_mapping cm ON (im.insights_property_id = cm.insights_property_id) 
            JOIN insights_contacts c ON(cm.contact_id = c.id) 
            LEFT JOIN property_details_mls mls ON (mls.id = im.inbestments_property_id) 
            LEFT JOIN insights_attom_property ap ON (ap.insights_property_id = im.insights_property_id 
            AND (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0)) 
            LEFT JOIN insights_mortgage_balance mb ON (mb.insights_property_id = im.insights_property_id) 

            LEFT JOIN insights_est_price_new_programmatic ep ON (ep.insights_property_id = im.insights_property_id 
            AND ep.is_best ='Y' AND ep.est_month = '". $month ."' AND ep.est_year = ". $year ." AND ep.pcomp_criteria_id!=0) 
            LEFT JOIN insights_send_mail_status isms ON isms.insights_property_id = im.insights_property_id   
            LEFT JOIN insights_property_details_by_user eu ON (eu.insights_property_id = im.insights_property_id) 
            LEFT JOIN insights_external_estimate ee ON (ee.insights_property_id = im.insights_property_id 
            AND ee.est_month = '". $month ."' AND ee.est_year = ". $year .") 
            LEFT JOIN insights_attom_assessment iaa ON iaa.insights_property_id  = im.insights_property_id 
            LEFT JOIN insights_cron_function_status icfs ON icfs.insights_property_id  = im.insights_property_id 
            WHERE im.record_status != 'R' 
            AND icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_IS_BEST_SET."'  AND icfs.month = '". $month ."' AND icfs.year = ". $year ."
            ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
             ";
       
            if (isset($queryCondition)) {
                $query .= $queryCondition;
            }
            
            if (isset($ConfigIn) && $ConfigIn!='' ) {
                $query .= " AND im.insights_property_id IN (SELECT icfs.insights_property_id FROM 
                insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf 
                ON icfs.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".$ConfigIn."'  
                 AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR." )";
            }
                      
            if (isset($ConfigNotIn) && $ConfigNotIn!='') {
                $query .= " AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM 
                insights_cron_function_status icfs LEFT JOIN insights_cron_function_frequency icf ON 
                icfs.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".$ConfigNotIn."'   
                AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR." )";
            }            
            $query .= " GROUP BY im.guid, im.insights_property_id, im.property_address, im.unit_number, im.property_city, im.property_state, im.property_zipcode, ep.id, ep.est_price, ee.est_price, ep.pcomp_criteria_id, ep.high_est_price, ep.low_est_price, ep.est_month, ep.est_year, ep.comp_properties, ep.criteria, im.agent_id, im.lender_id, mls.status,  im.record_status, ep.is_best, isms.send_mail ";
            if(AUTOMATION_CONDITION_WITH_ALIAS==''){
                if (isset($HavingCondition)) {
                    $query .= $HavingCondition;
                }
            }
            
            $query .= "  ORDER BY im.insights_property_id    ";
             $query .= "  LIMIT 30    ";
            $query .= "  ;";
           echo "HomeValueVariance :: <pre>";
        //   print_r($query);
 
            return $Obj->GetQuery($query);

        }
        public static function AdjustHomeValue($AdjustHomeValues)
        {
            $EstPrice=(double)$AdjustHomeValues['est_price'];
            $EstHighPrice=$AdjustHomeValues['high_est_price'];
            $EstLowPrice=$AdjustHomeValues['low_est_price'];
            $HomeValueAdjustPercent=$AdjustHomeValues['home_value_adjust_percent'];

            $NewAdjustHomeValues=array();
            $NewAdjustHomeValues['NewEstPrice']= ROUND((((double)$EstPrice * (double)$HomeValueAdjustPercent)/100)+(double)$EstPrice + RAND(100,500 ) );
            $NewAdjustHomeValues['NewHighEstPrice'] = ROUND((((double)$EstHighPrice *(double)$HomeValueAdjustPercent)/100)+(double)$EstHighPrice + RAND(100,500 ) );
            $NewAdjustHomeValues['NewLowEstPrice'] = ROUND((((double)$EstLowPrice *(double)$HomeValueAdjustPercent)/100)+(double)$EstLowPrice + RAND(100,500 ));
           
            return $NewAdjustHomeValues; 

        }
        public static function InsertAdjustedNewHomeValue($Data, $CronFunctionName)
        {


            $Parms = array(
                                
                'insights_property_id' => $Data['insights_property_id'],
                'est_price' => $Data['new_est_price'],
                'high_est_price' => $Data['new_high_est_price'],
                'low_est_price' => $Data['new_low_est_price'],
                'est_month' => $Data['est_month'],
                'est_year' => $Data['est_year'],
                'pcomp_criteria_id' => $Data['pcomp_criteria_id'],
                'comp_properties' => $Data['comp_properties'],
                'criteria' => $Data['criteria'],
                'is_best' => 'Y',
                'last_modified_by' => 0,
                'record_status' => 'A' 
            );  
             $InsertVarianceNewProgrammatic=Common::InsertData('insights_est_price_new_programmatic', $Parms,false); 
            if($Data['previous_month_available']==1){

                $Parms = array(
                    'cron_function_name' => $CronFunctionName, 
                    'insights_property_id' => $Data['insights_property_id'], 
                    'cron_function_status_flag' =>'Old: '.$Data['home_value_differnce']."% - New: ".$Data['current_home_value_differnce'].'%',  
                    'home_value_diff'=>$Data['home_value_differnce'],
                    'adjusted_home_value_diff'=>$Data['current_home_value_differnce'],
                    'previous_month_available'=>$Data['previous_month_available'],
                    'month' =>CURRENT_MONTH, 
                    'year' =>CURRENT_YEAR );  
                
            }
            if($Data['previous_month_available']==0){
              
                $Parms = array(
                    'cron_function_name' => $CronFunctionName, 
                    'insights_property_id' => $Data['insights_property_id'], 
                    'cron_function_status_flag' =>'Variance: '.$Data['Variance_Percent']."% - New: ".$Data['current_home_value_differnce'].'%',  
                    'home_value_diff'=>$Data['Variance_Percent'],
                    'adjusted_home_value_diff'=>$Data['current_home_value_differnce'],
                    'previous_month_available'=>$Data['previous_month_available'],
                    'month' =>CURRENT_MONTH, 
                    'year' =>CURRENT_YEAR );  
                
            }
             $UpdateCronFunctionStatus=Common::InsertData('insights_cron_function_status', $Parms,false); 
    
            $GetPropertyCurrentMonthData =self::GetInNewProgramaticRecord($Data['insights_property_id'], $Data['pcomp_criteria_id']);

            if(!empty($GetPropertyCurrentMonthData)){
                $Query = "UPDATE tbl_insights_est_price_new_programmatic SET is_best = 'O' WHERE  id=".$GetPropertyCurrentMonthData['id']." LIMIT 1 ";
                echo 'Query:: <pre>'; 
 
                echo '<hr>';               
                $Obj = new SqlManager();
                $Obj->ExecQuery($Query);            
            }
        
        }
        public static function GetInNewProgramaticRecord($InsightsPropertyID, $PCompCriteriaId)
        {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_est_price_new_programmatic'));
            $Obj->AddFlds(array('*'));
            $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
            $Obj->AddFldCond('pcomp_criteria_id', $PCompCriteriaId,'!=');
            $Obj->AddFldCond('is_best', 'Y');
            $Obj->AddFldCond('est_month', CURRENT_MONTH);
            $Obj->AddFldCond('est_year', CURRENT_YEAR);            
            return $Obj->GetSingle();
        }  

}
?>