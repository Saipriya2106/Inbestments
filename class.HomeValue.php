<?php 
class HomeValue{
    public function CallGetInbSubjectProperty($GetInbSubjectPropertiesActive)
    {
        if($GetInbSubjectPropertiesActive){
            $SubjectInbProperties = self::GetInbSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);
           // $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectInbProperties,CONFIG_IS_HOME_VALUE_COMPLETED,'P');              
            self::ProcessHV($SubjectInbProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_INB_SUBJECT_PROPERTIES);
        }
    
    }
    public function CallGetNonInbSubjectProperty($GetNonInbSubjectPropertiesActive)
    {
        if($GetNonInbSubjectPropertiesActive){
            $SubjectNonInbProperties = self::GetNonInbSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);

            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectNonInbProperties,CONFIG_IS_HOME_VALUE_COMPLETED,'P'); 
            self::ProcessHV($SubjectNonInbProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_NON_INB_SUBJECT_PROPERTIES);
        }   
    }
    public function CallGetExternalSubjectProperty($GetExternalSubjectPropertiesActive)
    {
        if($GetExternalSubjectPropertiesActive){
            $SubjectExternalProperties = self::GetExternalSubjectProperty(CURRENT_MONTH, CURRENT_YEAR);
            // echo 'SubjectExternalProperties :: <pre>';
            // print_r($SubjectExternalProperties);
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectExternalProperties,CONFIG_IS_HOME_VALUE_COMPLETED,'P'); 
            self::ProcessHV($SubjectExternalProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES);
        }        
    }
    public function CallGetInbSubjectPropertyRent($GetInbSubjectPropertiesForRentActive)
    {
        if($GetInbSubjectPropertiesForRentActive)
        {
            $InbSubjectProperties = self::GetInbSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
            // echo 'InbSubjectProperties :: <pre>';
            // print_r($InbSubjectProperties);        
         //   $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($InbSubjectProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED,'P'); 
            self::ProcessRE($InbSubjectProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT);    
        }        
    }

    public function CallGetNonInbSubjectPropertyRent($GetNonInbSubjectPropertiesForRentActive)
    {
        if($GetNonInbSubjectPropertiesForRentActive)
        {
            $NonInbSubjectProperties = self::GetNonInbSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
            // echo 'NonInbSubjectProperties :: <pre>';
            // print_r($NonInbSubjectProperties);        
        //    $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($NonInbSubjectProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED,'P'); 
            self::ProcessRE($NonInbSubjectProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_NON_INB_SUBJECT_PROPERTIES_FOR_RENT);
        }
    }
 
    public function CallGetExternalSubjectPropertyRent($GetExternalSubjectPropertiesForRentActive)
    {
        if($GetExternalSubjectPropertiesForRentActive)
        {
            $SubjectExternalProperties = self::GetExternalSubjectPropertyRent(CURRENT_MONTH, CURRENT_YEAR);
            // echo 'SubjectExternalProperties :: <pre>';
            // print_r($SubjectExternalProperties);      
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($SubjectExternalProperties,CONFIG_IS_RENT_ESTIMATE_COMPLETED,'P');   
            self::ProcessRE($SubjectExternalProperties, CURRENT_MONTH, CURRENT_YEAR,CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES_FOR_RENT);
        }
    }
    public static function SetHomeValueIsBest($M, $Y)
    {

        $QueryForInsights = "SELECT DISTINCT(im.insights_property_id), COUNT(im.pcomp_criteria_id) pCompCount, SUM(if(im.is_best= 'Y', 1, 0)) AS isBestY  
        FROM insights_est_price_new_programmatic im
        JOIN insights_cron_function_status icfs ON 
        (icfs.insights_property_id = im.insights_property_id AND icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."'    
         AND icfs.month=".$M." AND  icfs.year=".$Y.")
        WHERE im.est_month = '".$M."' AND im.est_year = ".$Y."
		".AUTOMATION_CONDITION_WITH_ALIAS." GROUP BY im.insights_property_id
        HAVING pCompCount > 0  AND isBestY = 0 ORDER BY im.insights_property_id DESC LIMIT 30 ";
		//  echo 'QueryForInsights: <pre> ';
        // print_r($QueryForInsights);
        
        $SPObj = new SqlManager();
        $SPData = $SPObj->GetQuery($QueryForInsights);
   
        foreach ($SPData as $Item) {
            if (isset($Item)  && isset($Item['insights_property_id'])) {
                $UpdateRecord = self::UpdateIsBestInsightPropertyId($Item['insights_property_id'], $M, $Y);
                if($UpdateRecord){
	                // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO
	                $Parms = array('cron_function_name' => CONFIG_IS_HOME_VALUE_IS_BEST_SET, 'insights_property_id' => $Item['insights_property_id'], 
	                'cron_function_status_flag' => 'Y',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
	                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
                }
            }
        }

    } 
    private static function UpdateIsBestInsightPropertyId($InsightsPropertyId,$M, $Y)
    {
        echo "###Started:".$InsightsPropertyId." @".date(DB_DATETIME_FORMAT)."\n";
        $QueryForIsBest = "
		SELECT best.id, best.insights_property_id, best.pcomp_criteria_id, best.comp_properties  FROM (  
		SELECT id, insights_property_id, (pcomp_criteria_id + 0) pcomp_criteria_id, comp_properties FROM insights_est_price_new_programmatic 
		WHERE 
		insights_property_id =".$InsightsPropertyId."
		AND est_month = '".$M."' AND est_year = ".$Y."  ORDER BY insights_property_id ASC, pcomp_criteria_id ASC) best GROUP BY insights_property_id;
		";
       // print_r($QueryForIsBest);
        $SPObjIsBest = new SqlManager();
        $SPDataIsBest = $SPObjIsBest->GetQuery($QueryForIsBest);
        // echo '<hr>$SPDataIsBest###: '; 
        // print_r($SPDataIsBest);
        if($SPDataIsBest[0]['comp_properties']==''){
            $ObjComps = new SqlManager();
            $Query1 = "SELECT comp_properties FROM `insights_est_price_new_programmatic` WHERE insights_property_id =".$InsightsPropertyId." AND est_month = '".$M."' AND est_year = ".$Y." 
            AND comp_properties !='' ORDER BY pcomp_criteria_id LIMIT 1;";
            //print_r($Query1);
            $GetComps = $ObjComps->GetQuery($Query1);
            // echo '<hr>$GetComps###: '; 
             
            if(!empty($GetComps)){
                if(isset($SPDataIsBest)){
                    $Obj = new SqlManager();
                    $Obj->AddTbls(array('insights_est_price_new_programmatic'));
                    $Obj->AddInsrtFlds(array('is_best' =>'Y', 'comp_properties'=>$GetComps[0]['comp_properties']));
                    $Obj->AddFldCond('id', $SPDataIsBest[0]['id']);
                    $UpdateId =  $Obj->Update();
                    return $UpdateId;
                } 
            }else {
                $Obj = new SqlManager();
                $Obj->AddTbls(array('insights_est_price_new_programmatic'));
                $Obj->AddInsrtFlds(array('is_best' =>'Y'));
                $Obj->AddFldCond('id', $SPDataIsBest[0]['id']);
                $UpdateId =  $Obj->Update();
                echo "###Finished###33333##:".$InsightsPropertyId." @".date(DB_DATETIME_FORMAT)."\n";
                return $UpdateId;
            }
        }else{
            if(isset($SPDataIsBest)){
                $Obj = new SqlManager();
                $Obj->AddTbls(array('insights_est_price_new_programmatic'));
                $Obj->AddInsrtFlds(array('is_best' =>'Y'));
                $Obj->AddFldCond('id', $SPDataIsBest[0]['id']);
                $UpdateId =  $Obj->Update();

                return $UpdateId;
            }
        }      

        
    }    

    public function GetInbSubjectProperty($M, $Y)
    {
         
        
        $Obj = new SqlManager();
        $Query = "SELECT im.inbestments_property_id id, im.insights_property_id insights_property_id, 
        mls.latitude, mls.longitude, sold_price, sold_date, mls.square_foot, property_type, style, mls.year_built, 
        IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, DATE('".$Y."-".$M."-01')), -1) sold_before 
        FROM 
        insights_main im 
        JOIN property_details_mls mls ON(im.inbestments_property_id = mls.id) 
        LEFT JOIN insights_est_price_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        LEFT JOIN insights_issues issue ON (im.insights_property_id = issue.insights_property_id)
        WHERE 
        im.inbestments_property_id IS NOT NULL 
        
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GET_INB_SUBJECT_PROPERTIES."'  AND  icf.cron_function_frequency='Monthly' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )";

        $Query = $Query." AND mls.latitude != 0 AND mls.longitude != 0
        AND im.inbestments_property_id > 0 
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND mls.square_foot > 0

        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 15";

       // print_r($Query);
        
        return $Obj->GetQuery($Query);
    }   
    public function GetNonInbSubjectProperty($M, $Y)
    {
        $Obj = new SqlManager();

        $Query = "SELECT 
        im.insights_property_id insights_property_id
        , ap.location_latitude latitude, ap.location_longitude longitude, ap.summary_year_built year_built
        , ap.summary_prop_land_use property_type, ap.living_size square_foot
        , 0 sold_price, -1 sold_before
        , algo.est_month
        FROM 
        insights_main im JOIN
        insights_attom_property ap 
        LEFT JOIN insights_est_price_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        LEFT JOIN insights_issues issue ON (im.insights_property_id = issue.insights_property_id)
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0)
       
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GET_NON_INB_SUBJECT_PROPERTIES."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )";
        $Query = $Query." AND im.checked_in_inbestments = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id = ap.insights_property_id 
        AND ap.location_latitude != 0 AND ap.location_longitude != 0
        AND ap.living_size > 0 
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 15";
        return $Obj->GetQuery($Query);
    }
    public function GetExternalSubjectProperty($M, $Y)
    {
        // Check the source (field) = 'U' for data which modified by user
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.insights_property_id insights_property_id, 
        zp.latitude, zp.longitude, zp.sold_last_for sold_price, zp.living_square_foot square_foot, zp.property_type property_type, 
        zp.year_built year_built, IF(zp.sold_last_on != DATE('0000-00-00'), TIMESTAMPDIFF(MONTH, zp.sold_last_on, DATE('".$Y."-".$M."-01')), -1) sold_before 
        FROM 
        insights_main im 
        JOIN insights_property_details_by_user zp ON(im.insights_property_id = zp.insights_property_id) 
        LEFT JOIN insights_est_price_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        LEFT JOIN insights_issues issue ON (im.insights_property_id = issue.insights_property_id)
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0 )";

        $Query = $Query."AND im.insights_property_id NOT IN (
			SELECT insights_property_id FROM insights_cron_function_status icfs 
			WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."'  AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )";

        $Query = $Query." AND im.insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icfs.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_EXTERNAL_API_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )
        
        AND im.tp_api = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.has_multi_match != 'Y'
        AND zp.living_square_foot > 0
      
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 15";
       // print_r($Query);
        return $Obj->GetQuery($Query);
    }
    public static function UpdatePricePropertiesAsBest($M, $Y)
    {
        $QueryForSP = "SELECT 
        TIMESTAMPDIFF(MONTH, mls.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
        mls.sold_price,
        im.guid,
        im.insights_property_id
        FROM insights_main im, property_details_mls mls 
        WHERE 
        im.inbestments_property_id = mls.id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND mls.sold_price > 0 AND `status` = 'Sold'
        AND mls.sold_date IS NOT NULL AND mls.sold_date != DATE('0000-00-00 00:00:00') AND mls.sold_date != '1800-01-01 00:00:00'
        AND im.insights_property_id NOT IN(
        SELECT ep.insights_property_id FROM insights_est_price_new_programmatic ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
        )
        AND im.insights_property_id IN(
        SELECT ep.insights_property_id FROM insights_est_price_new_programmatic ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        )

        HAVING
        sold_within BETWEEN 0 AND 6
        ";

       // print_r($QueryForSP);
        $SPObj = new SqlManager();
        $SPData = $SPObj->GetQuery($QueryForSP);

        if(!empty($SPData)){
            foreach ($SPData as $Item) {
                $BestRow = self::GetHomeValueByRangeForAMonth($Item, $M, $Y);
                if (isset($BestRow) && count($BestRow) && isset($BestRow['id'])) {
                    self::UpdateHomeValueIsBest($BestRow['id'],$Item);
                    // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO
                    $Parms = array('cron_function_name' => CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST, 'insights_property_id' => $Item['insights_property_id'], 
                    'cron_function_status_flag' => UpdateHomeValueIsBestHavingMlsNO,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
                }
            }
        }
        

        $QueryForSP = "SELECT 
        TIMESTAMPDIFF(MONTH, tblSmh.sold_date, DATE('".$Y."-".$M."-01')) sold_within,
        tblSmh.sold_price,
        im.guid,
        im.insights_property_id
        FROM insights_main im, 
        (SELECT sale_rec_date sold_date, sale_amt sold_price, insights_property_id FROM 
        (SELECT sale_rec_date, sale_amt, insights_property_id FROM insights_attom_sales_mortgage_history WHERE sale_amt > 0 AND sale_trans_type = 'Resale' ORDER BY sale_rec_date DESC)
        AS smh GROUP BY sale_rec_date, sale_amt,smh.insights_property_id)
        AS tblSmh 
        WHERE 
        (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0)
        AND im.insights_property_id = tblSmh.insights_property_id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND tblSmh.sold_date IS NOT NULL AND tblSmh.sold_date != DATE('0000-00-00 00:00:00')
        AND im.insights_property_id NOT IN(
        SELECT ep.insights_property_id FROM insights_est_price_new_programmatic ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND ep.is_best = 'Y'
        )
        AND im.insights_property_id IN(
        SELECT ep.insights_property_id FROM insights_est_price_new_programmatic ep WHERE ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        )
        HAVING
        sold_within BETWEEN 0 AND 6
        ";

      //  print_r($QueryForSP);
        $SPObj = new SqlManager();
        $SPData = $SPObj->GetQuery($QueryForSP);
        if(!empty($SPData)){
            foreach ($SPData as $Item) {
                $BestRow = self::GetHomeValueByRangeForAMonth($Item, $M, $Y);
                if (count($BestRow) && isset($BestRow) && isset($BestRow['id'])) {
                    self::UpdateHomeValueIsBest($BestRow['id'], $Item);
                    $Parms = array('cron_function_name' => CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST, 'insights_property_id' => $Item['insights_property_id'], 
                    'cron_function_status_flag' => UpdateHomeValueIsBestNotHavingMlsNO,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                    $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
                }
            }
        }

        $Query = "UPDATE insights_est_price_new_programmatic SET is_best = 'Y' WHERE  
        id IN(
            SELECT id FROM (SELECT best.id FROM (SELECT id, insights_property_id, (pcomp_criteria_id + 0) pcomp_criteria_id FROM insights_est_price_new_programmatic 
            WHERE 
            est_month = '".$M."' AND est_year = ".$Y." 
            ".AUTOMATION_CONDITION."
            AND insights_property_id NOT IN(SELECT insights_property_id FROM insights_est_price_new_programmatic WHERE est_month = '".$M."' AND est_year = ".$Y." AND is_best = 'Y')
            ORDER BY insights_property_id ASC, pcomp_criteria_id ASC) AS best
            GROUP BY insights_property_id
            LIMIT 100) As dtSet
        )";

    }
    function GetInbSubjectPropertyRent($M, $Y)
    {
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.inbestments_property_id id, im.insights_property_id insights_property_id, mls.latitude, mls.longitude, sold_price, sold_date, mls.square_foot, property_type, style, mls.year_built, IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, sold_date, NOW()), -1) sold_before 
        FROM 
        insights_main im 
        JOIN property_details_mls mls ON(im.inbestments_property_id = mls.id) 
        LEFT JOIN insights_est_rent_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        
        WHERE 
        im.inbestments_property_id IS NOT NULL 
        AND im.inbestments_property_id > 0 
        
        AND algo.est_month IS NULL AND algo.est_year IS NULL 
        AND mls.latitude != 0 AND mls.longitude != 0
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icf.cron_function_name='".CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )   
        AND im.insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )
                
        AND mls.square_foot > 0
        
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 50";
      //  print_r($Query);
        return $Obj->GetQuery($Query);
    }    

    function GetNonInbSubjectPropertyRent($M, $Y)
    {
        $Obj = new SqlManager();
        $Query = "SELECT im.insights_property_id, 
        ap.location_latitude latitude, ap.location_longitude longitude, 
        0 sold_price, 
        ap.summary_year_built year_built, ap.summary_prop_land_use property_type, 
        ap.gross_size square_foot, -1 sold_before, algo.est_month
        FROM insights_main im JOIN 
        insights_attom_property ap  
        LEFT JOIN insights_est_rent_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
        WHERE im.insights_property_id = ap.insights_property_id 
        AND (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0) 
        AND im.checked_in_inbestments = 'Y' ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS." ";

        $Query =  $Query." AND im.insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )

        AND ap.gross_size > 0
        AND algo.est_month IS NULL AND algo.est_year IS NULL 
         
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 30";

       // print_r($Query);
        return $Obj->GetQuery($Query);
    }

    public function GetExternalSubjectPropertyRent($M, $Y)
    {
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.insights_property_id insights_property_id, 
        zp.latitude, zp.longitude, zp.sold_last_for sold_price, zp.living_square_foot square_foot, zp.property_type property_type, 
        zp.year_built year_built, IF(zp.sold_last_on != DATE('0000-00-00'), TIMESTAMPDIFF(MONTH, zp.sold_last_on, DATE('".$Y."-".$M."-01')), -1) sold_before 
        FROM 
        insights_main im 
        JOIN insights_property_details_by_user zp ON(im.insights_property_id = zp.insights_property_id) 
        LEFT JOIN insights_est_rent_new_programmatic algo ON(algo.insights_property_id = im.insights_property_id 
        AND algo.est_month = '".$M."' AND algo.est_year = ".$Y.")
         
        WHERE 
        (im.inbestments_property_id IS NULL 
        OR im.inbestments_property_id = 0 )
        AND tp_api = 'Y'
        AND has_multi_match != 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS." "; 
       
        $Query = $Query." AND im.insights_property_id IN (SELECT insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name 
        WHERE icfs.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPLETED."' AND  icfs.cron_function_status_flag='Y' 
        AND icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."   )

        AND algo.est_month IS NULL AND algo.est_year IS NULL 
        AND zp.living_square_foot > 0
        
        GROUP BY im.insights_property_id
        ORDER BY im.insights_property_id DESC LIMIT 10"; 

     //   print_r($Query);
        return $Obj->GetQuery($Query);
    }    
     
    public function ProcessRE($SubjectProperties, $Month, $Year,$CronFunctionName) {
        global $LevelFilters;
        $TimeStamp = 'DATE(\''.$Year.'-'.$Month.'-01\')';
        foreach ($SubjectProperties as $SubjectProperty) {

            $CompsSet = self::GetRCompsSetToFilter($SubjectProperty, $TimeStamp);

            $LevelFilters = self::GetRLevelFilters();

            $CriteriaResults = array();

            $PreviousMonthData = self::GetPreviousMonthRData($SubjectProperty['insights_property_id'], $Month, $Year);

            if (count($PreviousMonthData)) {
                $Lvls = self::GetRStageByLevel($PreviousMonthData['rcomp_criteria_id']);

                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => PreviousMonthDataAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
                if (count($Lvls)) {
                    $CriteriaResults = self::RStage($SubjectProperty, $CompsSet, $CriteriaResults, $Lvls['StartLevel'], $Lvls['EndLevel'], $Month, $Year, true);
                    if (isset($CriteriaResults[$PreviousMonthData['rcomp_criteria_id']])) {
                        $EPTolerance = HVUtils::CalculateTolerance($PreviousMonthData['est_monthly_rent'], 3);
                        $LEPTolerance = $PreviousMonthData['est_monthly_rent'] - $EPTolerance;
                        $HEPTolerance = $PreviousMonthData['est_monthly_rent'] + $EPTolerance;

                        if ($CriteriaResults[$PreviousMonthData['rcomp_criteria_id']]['est_monthly_rent'] >= $LEPTolerance && $CriteriaResults[$PreviousMonthData['rcomp_criteria_id']]['est_monthly_rent'] <= $HEPTolerance) {
                            self::AddCalculatedRValues($CriteriaResults);
                            continue;
                        }
   
                        $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                        'cron_function_status_flag' => CriteriaResultsAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                           
                    }
                }
            }else {
               
                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => PreviousMonthDataNotAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
            }

            for ($i = 1, $j = 3; $i <= 425, $j <= 427; $i += 8, $j += 8) {
                if (!(isset($SubjectProperty['year_built']) && $SubjectProperty['year_built'] > 0) && ($i >= 1 && $i <= 41)) {
                    continue;
                }

                $CriteriaResults = self::RStage($SubjectProperty, $CompsSet, $CriteriaResults, $i, $j, $Month, $Year);
        
                if ($CriteriaResults === false) {
                    break;
                }
            }

            if ($CriteriaResults === false) {
                $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_RENT_ESTIMATE_COMPLETED,'Y'); 
                continue;
            }

            if ($CriteriaResults != null){
                self::AddCalculatedRValues($CriteriaResults);

                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => CalculatedValuesAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                 
            }
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_RENT_ESTIMATE_COMPLETED,'Y'); 
        }

        self::UpdateRentalPropertiesAsBest($Month, $Year);
    }
    public static function UpdateRentalPropertiesAsBest($M, $Y)
    {
        $Query = "UPDATE insights_est_rent_new_programmatic SET is_best = 'Y' WHERE  
        id IN(
            SELECT id FROM (SELECT best.id FROM (SELECT id, insights_property_id, (rcomp_criteria_id + 0) rcomp_criteria_id FROM insights_est_rent_new_programmatic 
            WHERE 
            est_month = '".$M."' AND est_year = ".$Y." 
            AND insights_property_id NOT IN(SELECT insights_property_id FROM insights_est_rent_new_programmatic WHERE est_month = '".$M."' AND est_year = ".$Y." AND is_best = 'Y')
            ORDER BY insights_property_id ASC, rcomp_criteria_id ASC) AS best
            GROUP BY insights_property_id
            LIMIT 100) As dtSet
        )";

        $Obj = new SqlManager();
        $Obj->ExecQuery($Query);
    }

    public static function AddCalculatedRValues($CriteriaResults)
    {
        self::InsertUpdateEstimatedRPrice(array_values($CriteriaResults));
     
    }

    public static function InsertUpdateEstimatedRPrice($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_rent_new_programmatic'));
        $Obj->AddInsrtFlds($Row);
        $Obj->InsertMultiple();
    }
    public static function RStage($SubjectProperty, $CompsSet, $CriteriaResults, $StartLevel, $EndLevel, $Month, $Year, $CheckingPrevious = false)
    {
        if ($StartLevel <= 185)
            $PropLimit = 3;
        else
            $PropLimit = 5;

        $CriteriaComps = array();
        global $LevelFilters;
        for ($Stage1Index = $StartLevel; $Stage1Index <= $EndLevel; $Stage1Index++) {
            $CriteriaComps[$Stage1Index] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage1Index], $CompsSet);
            if (count($CriteriaComps[$Stage1Index]) >= $PropLimit)
                $CriteriaResults[$Stage1Index] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage1Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage1Index], $Month, $Year, $Stage1Index);
        }
        
        $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $StartLevel, $EndLevel, $CriteriaResults);

        $AvgLevel = $EndLevel + 1;
        $S2StartLevel = $EndLevel + 2;
        $S2EndLevel = $EndLevel + 4;

        if (isset($CriteriaResults[$AvgLevel]) && isset($CriteriaResults[$AvgLevel]['median_est_monthly_rent']) && $CriteriaResults[$AvgLevel]['median_est_monthly_rent'] > 0) {
            $SalePriceHighLow = self::SalePriceHL($CriteriaResults[$AvgLevel]['median_est_monthly_rent'], 0.15);
            
            for ($Stage2Index = $S2StartLevel, $Stage1Index = $StartLevel; $Stage2Index <= $S2EndLevel; $Stage2Index++, $Stage1Index++) {
                $LevelFilters[$Stage2Index] = array_merge($LevelFilters[$Stage1Index], $SalePriceHighLow);

                $CriteriaComps[$Stage2Index] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage2Index], $CompsSet);
                if (count($CriteriaComps[$Stage2Index]) >= $PropLimit)
                    $CriteriaResults[$Stage2Index] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage2Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage2Index], $Month, $Year, $Stage2Index);
            }

            $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $S2StartLevel, $S2EndLevel, $CriteriaResults);
        }

        $S2AvgLevel = $S2EndLevel + 1;
        
        if (isset($CriteriaResults[$S2AvgLevel])) {
            if ($SubjectProperty['sold_before'] >= 0 && $SubjectProperty['sold_before'] <= 24 && $SubjectProperty['sold_price'] > $CriteriaResults[$S2AvgLevel]['est_monthly_rent'] && self::NegativeDiffrence($SubjectProperty['sold_price'], $CriteriaResults[$S2AvgLevel]['est_monthly_rent']) > 10) {
                if ($StartLevel >= 0)
                    $S3StartLevel = $StartLevel + 0.1;
                else
                    $S3StartLevel = $StartLevel - 0.1;

                if ($EndLevel >= 0)
                    $S3EndLevel = $EndLevel + 0.1;
                else
                    $S3EndLevel = $EndLevel - 0.1;

                for ($Stage3Index = $S3StartLevel, $Stage1Index = $StartLevel; $Stage3Index <= $S3EndLevel; $Stage3Index++, $Stage1Index++) {
                    $Stage3Key = $Stage3Index . '';
                    $LevelFilters[$Stage3Key] = array_merge($LevelFilters[$Stage1Index], array('sold_price_per' => 20));

                    $CriteriaComps[$Stage3Key] = self::FindRComps($SubjectProperty, $LevelFilters[$Stage3Key], $CompsSet);
                    if (count($CriteriaComps[$Stage3Key]) >= $PropLimit)
                        $CriteriaResults[$Stage3Key] = self::ProcessREstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage3Key], $SubjectProperty['square_foot'], $CriteriaComps[$Stage3Key], $Month, $Year, $Stage3Index);
                }
                $CriteriaResults = self::ProcessRAvgLevel($SubjectProperty['insights_property_id'], $S3StartLevel, $S3EndLevel, $CriteriaResults);
            }

            if (($CriteriaResults[$S2AvgLevel]['level_count'] >= 1 /*|| $CriteriaResults[$S2AvgLevel]['low_est_monthly_rent'] == $CriteriaResults[$S2AvgLevel]['high_est_monthly_rent']*/) && !$CheckingPrevious) {
                self::AddCalculatedRValues($CriteriaResults);
                return false;
            }
        }

        return $CriteriaResults;
    }
    public static function ProcessREstPrice($InsightsPropertyID, $Filter, $SquareFoot, $CompList, $Month, $Year, $CriteriaID)
    {
        $EstRow = array();
        $AveragePricePerSqFt = self::CalculateAveragePricePerSqFt($CompList);
        $EstimatedPrice = self::CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt);

        $EstRow['insights_property_id'] = $InsightsPropertyID;
        $EstRow['est_month'] = $Month;
        $EstRow['est_year'] = $Year;
        // echo "<hr>#1: ".$EstimatedPrice;  

        $EstimatedPrice =  round( $EstimatedPrice/50, 0) * 50;
        
        // echo "<hr>#2: ".$EstimatedPrice; 
        
        $EstRow['est_monthly_rent'] = $EstimatedPrice;
        $EstRow['rcomp_criteria_id'] = $CriteriaID;
        $Prices = self::ArrangeCompPrice($CompList);

        $CompLength = count($Prices);
        $comps_properties_count=0; 
        if($CompLength>0){
            $comps_properties_count =$CompLength; 
        }
        // echo '<hr> Original: ';
        // echo $Prices[0]." :: ".end($Prices)." *** ".round(array_sum($Prices) / $CompLength); 
        $LowEstMonthlyRent =  round( $Prices[0]/50, 0) * 50;
        $HighEstMonthlyRent = end($Prices); 
        $HighEstMonthlyRent = round( $HighEstMonthlyRent/50, 0) * 50;
        $AvgEstMonthlyRent =  round(array_sum($Prices) / $CompLength);
        $AvgEstMonthlyRent =  round( $AvgEstMonthlyRent/50, 0) * 50;
        // echo '<hr> RoundUp: ';
        // echo $LowEstMonthlyRent." :: ".$HighEstMonthlyRent." *** ".$AvgEstMonthlyRent; 
        // echo '<hr>';
        

        $EstRow['low_est_monthly_rent'] = $LowEstMonthlyRent;
        $EstRow['high_est_monthly_rent'] = $HighEstMonthlyRent;
        $EstRow['avg_est_monthly_rent'] = $AvgEstMonthlyRent;
        $EstRow['comps_properties_count'] = $comps_properties_count;

        $MidIndex = 0;
        if ($CompLength % 2 == 0) {
            $MidIndex = $CompLength / 2;
            $EstRow['median_est_monthly_rent'] = round(($Prices[$MidIndex] + $Prices[$MidIndex -1]) / 2);
        } else {
            $MidIndex = ($CompLength - 1) / 2;
            $EstRow['median_est_monthly_rent'] = $Prices[$MidIndex];
        }

        $EstRow['comp_properties'] = json_encode($CompList);
        if (!$EstRow['comp_properties'])
        $EstRow['comp_properties'] = '';
        $EstRow['criteria'] = json_encode($Filter);
        if (!$EstRow['criteria'])
        $EstRow['criteria'] = '';
        return $EstRow;
    }
    public static function ProcessRAvgLevel($InsightsPropertyID, $StartLevel, $EndLevel, $CriteriaResults)
    {
        $AvgLvl = $EndLevel + 1;
        $AvgData = array('est_monthly_rent' => 0, 'low_est_monthly_rent' => 0, 'high_est_monthly_rent' => 0, 'avg_est_monthly_rent' => 0, 'median_est_monthly_rent' => 0, 'level_count' => 0, 'comps_properties_count' => 0);

        for ($I = $StartLevel; $I <= $EndLevel; $I++) {
            if (!isset($CriteriaResults[$I]))
                continue;

            $AvgData['est_monthly_rent'] += $CriteriaResults[$I]['est_monthly_rent'];
            $AvgData['low_est_monthly_rent'] += $CriteriaResults[$I]['low_est_monthly_rent'];
            $AvgData['high_est_monthly_rent'] += $CriteriaResults[$I]['high_est_monthly_rent'];
            $AvgData['avg_est_monthly_rent'] += $CriteriaResults[$I]['avg_est_monthly_rent'];
            $AvgData['median_est_monthly_rent'] += $CriteriaResults[$I]['median_est_monthly_rent'];
            $AvgData['level_count'] += 1;

            $AvgData['est_month'] = $CriteriaResults[$I]['est_month'];
            $AvgData['est_year'] = $CriteriaResults[$I]['est_year'];
        }

        if ($AvgData['level_count'] > 0) {
            $AvgData['insights_property_id'] = $InsightsPropertyID;

            $AvgData['est_monthly_rent'] = $AvgData['est_monthly_rent']/$AvgData['level_count'];
            $AvgData['rcomp_criteria_id'] = $AvgLvl;
            $AvgData['low_est_monthly_rent'] = $AvgData['low_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['high_est_monthly_rent'] = $AvgData['high_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['avg_est_monthly_rent'] = $AvgData['avg_est_monthly_rent']/$AvgData['level_count'];
            $AvgData['median_est_monthly_rent'] = $AvgData['median_est_monthly_rent']/$AvgData['level_count'];

            $AvgData['comp_properties'] = '';
            $AvgData['criteria'] = '';

            $CriteriaResults[$AvgLvl . ''] = $AvgData;
        }

        return $CriteriaResults;
    }

    public static function GetRStageByLevel($RCompCriteriaID)
    {
        $Stage = array();
        for ($i = 1, $j = 3, $k = 8; $i <= 425, $j <= 427; $i += 8, $j += 8, $k += 8) {
            if ($RCompCriteriaID >= $i && $RCompCriteriaID <= $k) {
                $Stage = array('StartLevel' => $i, 'EndLevel' => $j);
                break;
            }
        }
        return $Stage;
    }
    public static function GetPreviousMonthRData($InsightsPropertyID, $CurrentMonth, $CurrentYear)
    {
        $Date = strtotime($CurrentYear.'-'.$CurrentMonth.'-01');
        $Month = date('m', strtotime('-1 month', $Date));
        $Year = date('Y', strtotime('-1 month', $Date));

        $Obj = new SqlManager();
        $Obj->AddTbls('insights_est_rent_new_programmatic');
        $Obj->AddFlds(array('est_monthly_rent', 'rcomp_criteria_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);
        $Obj->AddFldCond('is_best', 'Y');
        return $Obj->GetSingle();
    }
    public static function GetrCompsSetToFilter($Property, $TimeStamp = 'NOW()')
    {
        $Obj = new SqlManager();

        $SquareFootLow = 0;
        $SquareFootHigh = 0;

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 25);
        $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        $Query = "SELECT ";
        $Query .= "id,ml_number,list_price,IF(`status` = 'Sold',sold_price,list_price) sold_price,square_foot,style,`status`,sold_date,list_date,year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(DAY, sold_date, ".$TimeStamp."), -1) sold_within, ROUND((3958*acos(cos(radians(".$Property['latitude']."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$Property['longitude']."))+sin(radians(".$Property['latitude']."))*sin(radians(latitude))))* 100 / 100,2) AS distance,public_comments ";
        $Query .= " FROM property_rental_mls ";
        
        $Query .= " WHERE ";
        $Query .= " record_status != 'R' ";

        if ($SquareFootLow > 0 && $SquareFootHigh > 0)
            $Query .= " AND (square_foot BETWEEN ".$SquareFootLow." AND ".$SquareFootHigh.") ";
        
        
        $Query .= " AND (
            (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 365 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Active')
            OR (`status` LIKE 'Pending%' AND (pending_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
            OR (`status` = 'Contingent' AND (contingent_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
        )";
        
        if (isset($Property['id']))
            $Query .= " AND id != ".$Property['id'];

        $Query .= " GROUP BY address,unit_number,city_name,state_code,zip_code";
        $Query .= " HAVING distance <= 4.5";

        $Query .= " ORDER BY distance ASC, mls_created_date DESC";
        
        return $Obj->GetQuery($Query);
    }


    public static function UpdateAdjustmentPrice($M, $Y)
    {
        $Query = "SELECT 
        ep.id, sold_price, est_price, sold_date, list_price, mls.status, im.insights_property_id
        FROM insights_main im, insights_est_price_new_programmatic ep, property_details_mls mls
        WHERE 
        im.insights_property_id = ep.insights_property_id 
        ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND ep.is_best = 'Y' 
        AND ep.est_month = '".$M."' AND ep.est_year = ".$Y."
        AND im.inbestments_property_id IS NOT NULL 
        AND im.inbestments_property_id > 0
        AND ep.adjustment_value = 0
        AND im.inbestments_property_id = mls.id
        AND ((mls.status = 'Sold'
        AND mls.sold_price > ep.est_price
        AND (IF(`status` = 'Sold', TIMESTAMPDIFF(MONTH, mls.sold_date, DATE('".$Y."-".$M."-01')), -1) BETWEEN 0 AND 6)) 
        OR mls.status = 'Active')";

       // print_r($Query);

        $Obj = new SqlManager();
        $PropertyArr = $Obj->GetQuery($Query);
        $AdjustmentsArr = array();

        foreach ($PropertyArr as $Item) {
            if ($Item['status'] == 'Sold') {
                $Key = $Item['sold_price'].$Item['est_price'].$Item['sold_date'].'';
                if (!isset($AdjustmentsArr[$Key])) {
                    $adjustment = ($Item['sold_price'] * rand(50, 200) / 10000);
                    $AdjustmentsArr[$Key] = $Item['sold_price'] + $adjustment;
                }
            }
        }
        foreach ($PropertyArr as $Item) {
            if ($Item['status'] == 'Sold') {
                $Key = $Item['sold_price'].$Item['est_price'].$Item['sold_date'].'';
                $AdjustmentValue = $AdjustmentsArr[$Key];
            } else
                $AdjustmentValue = $Item['list_price'];
            self::UpdateAdjustmentValue($Item['id'], array('adjustment_value' => $AdjustmentValue));
            // Cron-Function-Status :: UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO
            $Parms = array('cron_function_name' => CONFIG_UPDATE_ADJUSTMENT_PRICE, 'insights_property_id' => $Item['insights_property_id'], 
            'cron_function_status_flag' => UpdateAdjustmentPrice,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);             
        }
    }
    public function HomeValueExternalCompare()
    {

        # Get the GetInsightsReportVarianceCondition from tbl_settings
        $VarianceCondition = Common::GetSettingValues('INSIGHTS_REPORT_VARIANCE_CONDITION');
        $HomeValueAdjustment = Common::GetSettingValues('HomeValue_Adjustment_Percent');
        $HomeValueAdjustmentPercent=$HomeValueAdjustment['option_value'];
        $HomeValueCompareDifference = 4;
        $VarianceCompareData = array();
        $n=0;        
        $Condition="  ";
        $HavingCondition="HAVING  `State` = 'WA' AND `Variance_Percent` <=".$HomeValueAdjustmentPercent."  ";
        $GetHomeValueCompleted = self::GetHomeValueCompleted(CURRENT_MONTH, CURRENT_YEAR, $Condition );
        echo "GetHomeValueCompleted::<pre>";
        print_r($GetHomeValueCompleted);
        if(!empty($GetHomeValueCompleted)){
            foreach($GetHomeValueCompleted as $PropertyItem) {
                $Parms = array('cron_function_name' => CONFIG_IS_HOME_VALUE_COMPARE_COMPLETED, 'insights_property_id' => $PropertyItem['insights_property_id'], 
                'cron_function_status_flag' => 'Y','tp_api'=>'N',  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR ); 
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
               
                $GetHomeValue = self::GetPrioritizeHomeValue($PropertyItem['insights_property_id']);
                if(empty($GetHomeValue))
                    $GetHomeValue = self::GetHomeValue($PropertyItem['insights_property_id']);
                
				$GetCompProperties = str_replace("'", "\'", $GetHomeValue[0]['comp_properties']);
				$GetCriteria = str_replace("'", "\'", $GetHomeValue[0]['criteria']);

                if(isset($GetHomeValue) && $GetHomeValue[0]['is_best']=='N' ){
                    $Query = "UPDATE insights_est_price_new_programmatic SET is_best = 'Y' WHERE  id=".$GetHomeValue[0]['id']." LIMIT 1 ";
                    echo 'Update Query:: <pre>'; 
                    print_r($Query);   
                    echo '<hr>';               
                    $Obj1 = new SqlManager();
                    $Obj1->ExecQuery($Query);            
                    
                }
                $GetExternalHomeValue = self::GetExternalHomeValue($PropertyItem['insights_property_id']);
                echo "GetHomeValue::<pre>";
                print_r($GetHomeValue);
                echo "GetExternalHomeValue::<pre>";
                print_r($GetExternalHomeValue);      
                
                $HomeValue= (isset($GetHomeValue) && $GetHomeValue[0]['est_price']!=0) ? (double)$GetHomeValue[0]['est_price'] : 0; 
                if(isset($GetExternalHomeValue)){
                    $ExternalHomeValue = (isset($GetExternalHomeValue) && $GetExternalHomeValue[0]['est_price']!=0)? (double)$GetExternalHomeValue[0]['est_price'] : 0;    
                }
                
                if($HomeValue!='' && $ExternalHomeValue!='' && isset($GetExternalHomeValue[0])) 
                {
                    $Query2 = "UPDATE insights_est_price_new_programmatic SET comp_properties = '".$GetCompProperties."', criteria = '".$GetCriteria."'   WHERE  id=".$GetExternalHomeValue[0]['id']." LIMIT 1 ";
                    echo 'Update Comp Property In External :: <pre>'; 
                    print_r($Query2);   
                    echo '<hr>';               
                    $Obj2 = new SqlManager();
                    $Obj2->ExecQuery($Query2);    

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
                      $UpdateIsBestOld=self::UpdateIsBestOld($PropertyItem['insights_property_id']);
                      $UpdateIsBest=self::UpdateIsBest($PropertyItem['insights_property_id'], $GetExternalHomeValue[0]['id'], $GetCompProperties);
                        
                      $Parms = array('cron_function_name' => CONFIG_HOME_VALUE_IS_BEST, 'insights_property_id' => $PropertyItem['insights_property_id'], 
                      'cron_function_status_flag' =>'pcomp_criteria_id: '.$GetExternalHomeValue[0]['pcomp_criteria_id'],  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR ); 
                      $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 

                    }                
                             
                }  
                
            }

        }        

    }
    public  function GetHomeValue($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM insights_est_price_new_programmatic WHERE insights_property_id=".$PropertyId." AND pcomp_criteria_id!=10000  
        AND est_month='".CURRENT_MONTH."' AND est_year= ".CURRENT_YEAR." ORDER BY pcomp_criteria_id  LIMIT 1"; 
        // print_r($Query);			
        return $Obj->GetQuery($Query);  	
    }

    public static function GetPrioritizeHomeValue($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM `insights_est_price_new_programmatic` WHERE insights_property_id = ".$PropertyId." AND criteria != '' AND comp_properties != '' AND
        JSON_VALID(criteria) = 1 AND JSON_VALID(comp_properties) = 1 AND 
        JSON_EXTRACT(criteria, '$.set_style') = 'absolute' AND JSON_EXTRACT(criteria, '$.distance') = 0.5 AND JSON_LENGTH(comp_properties) >= 3 ORDER BY id DESC LIMIT 1;"; 
        // print_r($Query);			
        return $Obj->GetQuery($Query);  	
    }
    public  function GetExternalHomeValue($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM insights_est_price_new_programmatic WHERE insights_property_id=".$PropertyId." AND pcomp_criteria_id=10000 
        AND est_month='".CURRENT_MONTH."' AND est_year= ".CURRENT_YEAR." ORDER BY est_price DESC LIMIT 1"; 
        // print_r($Query);			
        return $Obj->GetQuery($Query);  	
    }       
    
    public  function UpdateIsBestOld($PropertyId)
    {
        $Obj = new SqlManager();
        $Query = "UPDATE `insights_est_price_new_programmatic` SET `is_best` = 'O' WHERE `is_best` = 'Y' AND insights_property_id=".$PropertyId." 
        AND est_month='".CURRENT_MONTH."' AND est_year= ".CURRENT_YEAR."  LIMIT 1
        "; 
        echo '<pre>';
        print_r($Query);			
         $Obj->ExecQuery($Query);  	
    }    
    
    public  function UpdateIsBest($PropertyId, $RowId, $GetCompProperties)
    {
        $Obj = new SqlManager();
        $Query = "UPDATE `insights_est_price_new_programmatic` SET `is_best` = 'Y', comp_properties='".$GetCompProperties."'  WHERE  `id` = '".$RowId."' AND insights_property_id=".$PropertyId." 
        AND est_month='".CURRENT_MONTH."' AND est_year= ".CURRENT_YEAR." LIMIT 1 "; 
        echo '<pre>';
        print_r($Query);			
         $Obj->ExecQuery($Query);  	
    }       

    public  function GetHomeValueCompleted($month, $year, $queryCondition)
    {
        $Obj = new SqlManager();
        $query = "SELECT  im.guid, im.insights_property_id, im.property_address `Address`, im.unit_number `Unit_Number`, im.property_city `City`, 
                    im.property_state `State`, im.property_zipcode `Zip_Code`  
                    FROM insights_main im LEFT JOIN insights_cron_function_status icfs ON icfs.insights_property_id  = im.insights_property_id 
                    WHERE im.record_status != 'R' AND icfs.cron_function_name='IS_HOME_VALUE_COMPLETED' AND icfs.cron_function_status_flag='Y'  
                    AND icfs.month =". $month ." AND icfs.year = ". $year ." AND im.insights_property_id NOT IN (SELECT icfs1.insights_property_id 
                    FROM insights_cron_function_status   icfs1
                    WHERE icfs1.cron_function_name='".CONFIG_IS_HOME_VALUE_COMPARE_COMPLETED."'  AND icfs1.cron_function_status_flag='Y' 
                     AND icfs1.month=". $month ." AND  icfs1.year=". $year ."  )                         
                     ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS."  ".AUTOMATION_CONDITION_WITH_ALIAS."";
       
        if (isset($queryCondition)) {
            $query .= $queryCondition;
        }
        $query .= "  ORDER BY im.insights_property_id    ";
        $query .= "  LIMIT 5    ";
        $query .= "  ;";
        echo "query:: <pre>";
        print_r($query);
        return $Obj->GetQuery($query);
    }   
        
    private static function UpdateAdjustmentValue($ID, $Data)
    {
        if ($ID > 0) {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_est_price_new_programmatic'));
            $Obj->AddInsrtFlds($Data);
            $Obj->AddFldCond('id', $ID);
            $Obj->Update();
        }
    }
    private static function GetHomeValueByRangeForAMonth($Row, $M, $Y)
    {
        $SoldPriceTolerance = HVUtils::CalculateTolerance($Row['sold_price'], 5);
        $SoldPriceHigh = $Row['sold_price'] + $SoldPriceTolerance;

        $Query = "SELECT ep.id, ep.est_price FROM insights_est_price_new_programmatic ep WHERE ep.insights_property_id = ".$Row['insights_property_id']." AND ep.est_month = '".$M."' AND ep.est_year = ".$Y." AND est_price BETWEEN '".$Row['sold_price']."' AND '".$SoldPriceHigh."' ORDER BY ep.est_price DESC LIMIT 1";

        $Obj = new SqlManager();
        return $Obj->GetQuery($Query);
    }
    private static function UpdateHomeValueIsBest($ID, $Item)
    {
        $isBest='Y';
        $CheckIsBest = self::CheckHomeValueIsBest($Item);
        if (count($CheckIsBest)) {
            $isBest='P';
        }
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_new_programmatic'));
        $Obj->AddInsrtFlds(array('is_best' =>$isBest));
        $Obj->AddFldCond('id', $ID);
        $Obj->Update();
    }

    public static function  CheckHomeValueIsBest($Item)
    {
            $Obj = new SqlManager();
              $Obj->AddTbls(array('insights_est_price_new_programmatic'));
              $Obj->AddFlds(array('id'));
              $Obj->AddFldCond('insights_property_id', $Item['insights_property_id']);
              $Obj->AddFldCond('is_best', 'Y');
              $Obj->AddFldCond('est_month', $Item['est_month']);
              $Obj->AddFldCond('est_year', $Item['est_year']);
              return $Obj->GetSingle();
    }    
    public static function UpdateInsightsMain($Data, $InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_main'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->Update();
    }
    public static function GetStageByLevel($PCompCriteriaID)
    {
        $Stage = array();
        for ($i = 1, $j = 3, $k = 8; $i <= 449, $j <= 451; $i += 8, $j += 8, $k += 8) {
            if ($PCompCriteriaID >= $i && $PCompCriteriaID <= $k) {
                $Stage = array('StartLevel' => $i, 'EndLevel' => $j);
                break;
            }
        }
        return $Stage;
    }
    public static function GetCompsSetToFilter($Property, $StricterRange = 1, $TimeStamp = 'NOW()')
    {
        $Obj = new SqlManager();

        $SquareFootLow = 0;
        $SquareFootHigh = 0;

        $PropertyType = '';
        if(isset($Property['property_type'])){
            if ($Property['property_type'] == 'SFR' || $Property['property_type'] == 'RESIDENTIAL ACREAGE' || $Property['property_type'] == 'RESIDENTIAL (NEC)' || $Property['property_type'] == 'SingleFamily')
            $PropertyType = 'Residential';
        else if ($Property['property_type'] == 'CONDOMINIUM' || $Property['property_type'] == 'Condominium')
            $PropertyType = 'Condominium';
        else if ($Property['property_type'] == 'MultiFamily5Plus' || $Property['property_type'] == 'MultiFamily2To4')
            $PropertyType = 'Multi-Family';
        else if ($Property['property_type'] == 'INDUSTRIAL (NEC)' || $Property['property_type'] == 'WAREHOUSE' || $Property['property_type'] == 'MOBILE HOME'
        || $Property['property_type'] == 'VacantResidentialLand' || $Property['property_type'] == 'Duplex' || $Property['property_type'] == 'Apartment'
        || $Property['property_type'] == 'Townhouse' || $Property['property_type'] == 'Mobile') {
            $PropertyType = '';
        } else
            $PropertyType = $Property['property_type'];
        }
   

        $Query = "SELECT ";
        $Query .= "id,ml_number,list_price,IF(`status` = 'Sold',sold_price,list_price) sold_price,square_foot,style,`status`,sold_date,list_date,year_built,IF(`status` = 'Sold', TIMESTAMPDIFF(DAY, sold_date, ".$TimeStamp."), -1) sold_within, ROUND((3958*acos(cos(radians(".$Property['latitude']."))*cos(radians(latitude))*cos(radians(longitude)-radians(".$Property['longitude']."))+sin(radians(".$Property['latitude']."))*sin(radians(latitude))))* 100 / 100,2) AS distance,public_comments ";
        $Query .= " FROM property_details_mls ";
        $Query .= " WHERE ";
        
        $QueryCondition = array();

        if ($PropertyType != '')
            $QueryCondition[] = " property_type = '".$PropertyType."' ";

        if ($StricterRange == 1) {
            $QueryCondition[] = " record_status != 'R' ";

            $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 40);
            $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
            $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

            $QueryCondition[] = " (
                (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 365 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Active')
                OR (`status` LIKE 'Pending%' AND (pending_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Contingent' AND (contingent_date between DATE_SUB(".$TimeStamp.", INTERVAL 14 DAY) AND ".$TimeStamp."))
            )";
        } else if ($StricterRange == 2) {
            $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], 100);
            $SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
            $SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

            $QueryCondition[] = " (
                (`status` = 'Sold' AND (sold_date between DATE_SUB(".$TimeStamp.", INTERVAL 730 DAY) AND ".$TimeStamp."))
                OR (`status` = 'Active')
                OR (`status` LIKE 'Pending%')
                OR (`status` = 'Contingent')
                OR (`status` = 'Removed')
            )";
        }

        if ($SquareFootLow > 0 && $SquareFootHigh > 0)
            $QueryCondition[] = " (square_foot BETWEEN ".$SquareFootLow." AND ".$SquareFootHigh.") ";
        
        if (isset($Property['id']))
            $QueryCondition[] = " id != ".$Property['id'];

        $Query .= " ".implode(' AND ', $QueryCondition)." ";
        $Query .= " GROUP BY id,ml_number,list_price";
       // $Query .= " GROUP BY address,unit_number,city_name,state_code,zip_code";
        $Query .= " HAVING distance <= 3";
        
        $Query .= " ORDER BY distance ASC, mls_created_date DESC";
       // print_r($Query);
        return $Obj->GetQuery($Query);
    }
    public static function FindComps($Property, $Filter, $DataSet)
    {
        $FinalDataSet = array();

        $FilterObj = new HVFilter();
        $FilterObj->setFilterParameters($Filter);
        $FilterObj->setSubjectProperty($Property);

        $FinalDataSet = array_filter($DataSet, [$FilterObj, 'distance']);
        
        if (isset($Filter['year_built_tolerance']) && $Filter['year_built_tolerance'] > 0) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'yearBuilt']);
        }

        if (isset($Filter['sold_within']) && $Filter['sold_within'] <= 180) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldWithin']);
        }

        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'squareFoot']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'status']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldPrice']);

        if (isset($Filter['set_style']) && isset($Property['style']) && $Property['style'] != '') {
            if ($Filter['set_style'] == 'absolute')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
            else if ($Filter['set_style'] == 'relative')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        }

        if (!(isset($Filter['text_mining_exclusion']) && $Filter['text_mining_exclusion'] === true)) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'excludePublicComments']);
        }
        
        return array_slice($FinalDataSet, 0, 50);
    }
    public static function NegativeDiffrence($SalePrice, $EstPrice)
    {
        return ( ( ($SalePrice - $EstPrice) / $SalePrice) * 100 );
    }

    public static function FindRComps($Property, $Filter, $DataSet)
    {
        $FinalDataSet = array();

        $FilterObj = new HVFilter();
        $FilterObj->setFilterParameters($Filter);
        $FilterObj->setSubjectProperty($Property);

        $FinalDataSet = array_filter($DataSet, [$FilterObj, 'distance']);
        
        if (isset($Filter['year_built_tolerance']) && $Filter['year_built_tolerance'] > 0) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'yearBuilt']);
        }

        if (isset($Filter['sold_within']) && $Filter['sold_within'] <= 180) {
            $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldWithin']);
        }

        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'squareFoot']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'status']);
        $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'soldPrice']);

        if (isset($Filter['set_style']) && isset($Property['style']) && $Property['style'] != '') {
            if ($Filter['set_style'] == 'absolute')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'absoluteStyle']);
            else if ($Filter['set_style'] == 'relative')
                $FinalDataSet = array_filter($FinalDataSet, [$FilterObj, 'relativeStyle']);
        }

        return array_slice($FinalDataSet, 0, 50);
    }

    public static function Stage($SubjectProperty, $DataSet, $CriteriaResults, $StartLevel, $EndLevel, $Month, $Year, $CheckingPrevious = false)
    {
        if ($StartLevel <= 281)
            $PropLimit = 3;
        else if ($StartLevel > 281 && $StartLevel <= 433)
            $PropLimit = 5;
        else
            $PropLimit = 2; 

        $CriteriaComps = array();
        global $LevelFilters;
        for ($Stage1Index = $StartLevel; $Stage1Index <= $EndLevel; $Stage1Index++) {
            $CriteriaComps[$Stage1Index] = self::FindComps($SubjectProperty, $LevelFilters[$Stage1Index], $DataSet);
            
            // print_r($CriteriaComps[$Stage1Index]);
            // exit;

            if (count($CriteriaComps[$Stage1Index]) >= $PropLimit) {
                // $CriteriaResults[$Stage1Index] = array();
                $CriteriaResults[$Stage1Index] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage1Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage1Index], $Month, $Year, $Stage1Index);
            }
        }
        
        $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $StartLevel, $EndLevel, $CriteriaResults);

        $AvgLevel = $EndLevel + 1;
        $S2StartLevel = $EndLevel + 2;
        $S2EndLevel = $EndLevel + 4;

        if (isset($CriteriaResults[$AvgLevel]) && isset($CriteriaResults[$AvgLevel]['mid_est_price']) && $CriteriaResults[$AvgLevel]['mid_est_price'] > 0) {
            $SalePriceHighLow = self::SalePriceHL($CriteriaResults[$AvgLevel]['mid_est_price'], 0.15);
            
            for ($Stage2Index = $S2StartLevel, $Stage1Index = $StartLevel; $Stage2Index <= $S2EndLevel; $Stage2Index++, $Stage1Index++) {
                $LevelFilters[$Stage2Index] = array_merge($LevelFilters[$Stage1Index], $SalePriceHighLow);

                $CriteriaComps[$Stage2Index] = self::FindComps($SubjectProperty, $LevelFilters[$Stage2Index], $DataSet);
                if (count($CriteriaComps[$Stage2Index]) >= $PropLimit)
                    $CriteriaResults[$Stage2Index] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage2Index], $SubjectProperty['square_foot'], $CriteriaComps[$Stage2Index], $Month, $Year, $Stage2Index);
            }

            $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $S2StartLevel, $S2EndLevel, $CriteriaResults);
        }

        $S2AvgLevel = $S2EndLevel + 1;
        
        if (isset($CriteriaResults[$S2AvgLevel])) {
            if ($SubjectProperty['sold_before'] >= 0 && $SubjectProperty['sold_before'] <= 24 && $SubjectProperty['sold_price'] > $CriteriaResults[$S2AvgLevel]['est_price'] && self::NegativeDiffrence($SubjectProperty['sold_price'], $CriteriaResults[$S2AvgLevel]['est_price']) > 10) {
                if ($StartLevel >= 0)
                    $S3StartLevel = $StartLevel + 0.1;
                else
                    $S3StartLevel = $StartLevel - 0.1;

                if ($EndLevel >= 0)
                    $S3EndLevel = $EndLevel + 0.1;
                else
                    $S3EndLevel = $EndLevel - 0.1;

                for ($Stage3Index = $S3StartLevel, $Stage1Index = $StartLevel; $Stage3Index <= $S3EndLevel; $Stage3Index++, $Stage1Index++) {
                    $Stage3Key = $Stage3Index . '';
                    $LevelFilters[$Stage3Key] = array_merge($LevelFilters[$Stage1Index], array('sold_price_per' => 20));

                    $CriteriaComps[$Stage3Key] = self::FindComps($SubjectProperty, $LevelFilters[$Stage3Key], $DataSet);
                    if (count($CriteriaComps[$Stage3Key]) >= $PropLimit)
                        $CriteriaResults[$Stage3Key] = self::ProcessEstPrice($SubjectProperty['insights_property_id'], $LevelFilters[$Stage3Key], $SubjectProperty['square_foot'], $CriteriaComps[$Stage3Key], $Month, $Year, $Stage3Index);
                }
                $CriteriaResults = self::ProcessAvgLevel($SubjectProperty['insights_property_id'], $S3StartLevel, $S3EndLevel, $CriteriaResults);
            }

            if (!($CriteriaResults[$S2AvgLevel]['level_count'] == 1 || $CriteriaResults[$S2AvgLevel]['low_est_price'] == $CriteriaResults[$S2AvgLevel]['high_est_price']) && !$CheckingPrevious) {
                self::AddCalculatedValues($CriteriaResults);
                return false;
            }
        }

        return $CriteriaResults;
    }
    public static function SalePriceHL($MedianEP, $Tolerance)
    {
        return array('sold_price_low' => ($MedianEP * (1 - $Tolerance)), 'sold_price_high' => ($MedianEP * (1 + $Tolerance)));
    }
    public static function ProcessAvgLevel($InsightsPropertyID, $StartLevel, $EndLevel, $CriteriaResults)
    {
        $AvgLvl = $EndLevel + 1;
        $AvgData = array('est_price' => 0, 'low_est_price' => 0, 'high_est_price' => 0, 'avg_est_price' => 0, 'mid_est_price' => 0, 'level_count' => 0, 'comps_properties_count' => 0 );
        for ($I = $StartLevel; $I <= $EndLevel; $I++) {
            if (!isset($CriteriaResults[$I]))
                continue;

            $AvgData['est_price'] += $CriteriaResults[$I]['est_price'];
            $AvgData['low_est_price'] += $CriteriaResults[$I]['low_est_price'];
            $AvgData['high_est_price'] += $CriteriaResults[$I]['high_est_price'];
            $AvgData['avg_est_price'] += $CriteriaResults[$I]['avg_est_price'];
            $AvgData['mid_est_price'] += $CriteriaResults[$I]['mid_est_price'];
            $AvgData['level_count'] += 1;

            $AvgData['est_month'] = $CriteriaResults[$I]['est_month'];
            $AvgData['est_year'] = $CriteriaResults[$I]['est_year'];
        }

        if ($AvgData['level_count'] > 0) {
            $AvgData['insights_property_id'] = $InsightsPropertyID;

            $AvgData['est_price'] = $AvgData['est_price']/$AvgData['level_count'];
            $AvgData['pcomp_criteria_id'] = $AvgLvl;
            $AvgData['low_est_price'] = $AvgData['low_est_price']/$AvgData['level_count'];
            $AvgData['high_est_price'] = $AvgData['high_est_price']/$AvgData['level_count'];
            $AvgData['avg_est_price'] = $AvgData['avg_est_price']/$AvgData['level_count'];
            $AvgData['mid_est_price'] = $AvgData['mid_est_price']/$AvgData['level_count'];
            
            $AvgData['comp_properties'] = '';
            $AvgData['criteria'] = '';
            $CriteriaResults[$AvgLvl . ''] = $AvgData;            
        }

        return $CriteriaResults;
    }
    public static function CalculateAveragePricePerSqFt($Properties)
    {
        if (!count($Properties))
            return 0;

        $CalculatedValue = 0;
        foreach ($Properties as $Property)
            $CalculatedValue += self::CalculatePricePerSqFt($Property['sold_price'], $Property['square_foot']);

        return round($CalculatedValue / count($Properties), 2);
    }
    private static function CalculatePricePerSqFt($ComparablePropertyPrice, $ComparablePropertySquareFoot)
    {
        if ($ComparablePropertySquareFoot > 0)
            return $ComparablePropertyPrice / $ComparablePropertySquareFoot;
        return 0;    
    }


    public static function ArrangeCompPrice($CompData)
    {
        $Prices = array();
        foreach ($CompData as $Item)
            $Prices[] = intval($Item['sold_price']);
        sort($Prices);
        return $Prices;
    }
    public static function CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt)
    {
        return round($SquareFoot * $AveragePricePerSqFt);
    }

    public static function ProcessEstPrice($InsightsPropertyID, $Filter, $SquareFoot, $CompList, $Month, $Year, $CriteriaID)
    {
        $EstRow = array();
        $AveragePricePerSqFt = self::CalculateAveragePricePerSqFt($CompList);

        $EstimatedPrice = self::CalculateEstimatedPrice($SquareFoot, $AveragePricePerSqFt);

        $EstRow['insights_property_id'] = $InsightsPropertyID;
        $EstRow['est_month'] = $Month;
        $EstRow['est_year'] = $Year;
        $EstRow['est_price'] = $EstimatedPrice;
        $EstRow['pcomp_criteria_id'] = $CriteriaID;
        $Prices = self::ArrangeCompPrice($CompList);

        $CompLength = count($Prices);
        $comps_properties_count=0; 
        if($CompLength>0){
            $comps_properties_count =$CompLength; 
        };
        $EstRow['low_est_price'] = $Prices[0];
        $EstRow['high_est_price'] = end($Prices);
        $EstRow['avg_est_price'] = round(array_sum($Prices) / $CompLength);
        $EstRow['comps_properties_count'] = $comps_properties_count;
        $MidIndex = 0;
        if ($CompLength % 2 == 0) {
            $MidIndex = $CompLength / 2;
            $EstRow['mid_est_price'] = round(($Prices[$MidIndex] + $Prices[$MidIndex -1]) / 2);
        } else {
            $MidIndex = ($CompLength - 1) / 2;
            $EstRow['mid_est_price'] = $Prices[$MidIndex];
        }

        $EstRow['comp_properties'] = json_encode($CompList);
        if (!$EstRow['comp_properties'])
        $EstRow['comp_properties'] = '';
        $EstRow['criteria'] = json_encode($Filter);
        if (!$EstRow['criteria'])
        $EstRow['criteria'] = '';
        
        if (!$EstRow['comp_properties']){
            $EstRow['comps_properties_count']=0;
        }
        return $EstRow;
    }
    public function ProcessHV($SubjectProperties, $Month, $Year,$CronFunctionName) {
        global $LevelFilters;
        $TimeStamp = 'DATE(\''.$Year.'-'.$Month.'-01\')';
        print_r($SubjectProperties);
        foreach ($SubjectProperties as $SubjectProperty) {
    
            $CompsSet = array();
            
            $LevelFilters = self::GetLevelFilters();
    
            $CriteriaResults = array();
    
            $PreviousMonthData = self::GetPreviousMonthData($SubjectProperty['insights_property_id'], $Month, $Year);
            echo '$PreviousMonthData';
            print_r($PreviousMonthData);
         //   self::UpdateInsightsMain(array('checked_for_inbestments_avm' => 'Y'), $SubjectProperty['insights_property_id']);
            
            if (count($PreviousMonthData)) {
                $Lvls = self::GetStageByLevel($PreviousMonthData['pcomp_criteria_id']);

                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => PreviousMonthDataAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
              //  $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                       
                if (isset($Lvls['StartLevel']) && $Lvls['StartLevel'] >= 441) {
                    $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 2, $TimeStamp);
                } else {
                    $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 1, $TimeStamp);
                }
                if (count($CompsSet) !== 0){
  
                    $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                    'cron_function_status_flag' => CompSetAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                  //  $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false); 
                }                
                if (count($Lvls)) {
                    $CriteriaResults = self::Stage($SubjectProperty, $CompsSet, $CriteriaResults, $Lvls['StartLevel'], $Lvls['EndLevel'], $Month, $Year, true);
                    if (isset($CriteriaResults[$PreviousMonthData['pcomp_criteria_id']])) {
                        $EPTolerance = HVUtils::CalculateTolerance($PreviousMonthData['est_price'], 3);
                        $LEPTolerance = $PreviousMonthData['est_price'] - $EPTolerance;
                        $HEPTolerance = $PreviousMonthData['est_price'] + $EPTolerance;
    
                        if ($CriteriaResults[$PreviousMonthData['pcomp_criteria_id']]['est_price'] >= $LEPTolerance && $CriteriaResults[$PreviousMonthData['pcomp_criteria_id']]['est_price'] <= $HEPTolerance) {
                            self::AddCalculatedValues($CriteriaResults);
                            continue;
                        }
                
                        $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                        'cron_function_status_flag' => CriteriaResultsAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                        $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                       
                    }
                  
                }

            }else{

                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => PreviousMonthDataNotAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
               // $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                           
            }

            if (count($CompsSet) === 0) {
                $CompsSet = HomeValue::GetCompsSetToFilter($SubjectProperty, 1, $TimeStamp);

                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => CompSetNotAvailable,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
            
            }
            for ($i = 1, $j = 3; $i <= 449, $j <= 451; $i += 8, $j += 8) {
                if (!(isset($SubjectProperty['year_built']) && $SubjectProperty['year_built'] > 0) && (($i >= 1 && $i <= 41) || ($i >= 97 && $i <= 137))) {
                    continue;
                }
    
                if ($i == 441) {
                    $CompsSet = self::GetCompsSetToFilter($SubjectProperty, 2, $TimeStamp);
                }

                $CriteriaResults = self::Stage($SubjectProperty, $CompsSet, $CriteriaResults, $i, $j, $Month, $Year);

                if ($CriteriaResults === false) {
                    
                    break;
                }
            }
            // echo '<hr>step4 :: ';  
            if ($CriteriaResults === false) {
            //    echo '<hr> step5 :: ';  
               Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_HOME_VALUE_COMPLETED,'Y');   
                continue;
            }
    
            if ($CriteriaResults != null && is_array($CriteriaResults))
            {
                self::AddCalculatedValues($CriteriaResults);
            }
                
                // Cron-Function-Status - CALCULATED_VALUES_ADDED
                $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $SubjectProperty['insights_property_id'], 
                'cron_function_status_flag' => CalculatedValuesAdded,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);     

              //  Common::UpdateCronCompleteStatus($SubjectProperty['insights_property_id'], CONFIG_IS_HOME_VALUE_COMPLETED,'Y');    
        }
    }
    public static function GetPreviousMonthData($InsightsPropertyID, $CurrentMonth, $CurrentYear)
    {
        $Date = strtotime($CurrentYear.'-'.$CurrentMonth.'-01');
        $Month = date('m', strtotime('-1 month', $Date));
        $Year = date('Y', strtotime('-1 month', $Date));

        $Obj = new SqlManager();
        $Obj->AddTbls('insights_est_price_new_programmatic');
        $Obj->AddFlds(array('est_price', 'pcomp_criteria_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);
        $Obj->AddFldCond('is_best', 'Y');
        return $Obj->GetSingle();
    }
    public static function InsertUpdateEstimatedPrice($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_new_programmatic'));
        $Obj->AddInsrtFlds($Row);
        $Obj->InsertMultiple();    
    }
    public static function AddCalculatedValues($CriteriaResults)
    {
        self::InsertUpdateEstimatedPrice(array_values($CriteriaResults));
    }
    public static function GetLevelFilters()
    {
        $LevelFilters = array();

        /* Stage 1 Level 1 to 8 */
        $LevelFilters[1] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[2] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[3] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        /* 
        Level 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, ... : will have the average value of the previous three levels, 
        e.g. Level 4 will be the average of Level 1, 2, 3
        
        Level 4.1, 12.1, 20.1, 28.1, 36.1, ... : will have the average value of the previous three levels, 
        e.g. Level 4.1 will be the average of Level 1.1, 2.1, 3.1
        */

        $LevelFilters[9] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[10] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[11] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[17] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[18] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[19] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[25] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[26] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[27] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[33] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[34] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[35] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[41] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[42] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[43] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[49] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[50] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[51] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[57] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[58] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[59] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[65] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[66] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[67] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[73] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[74] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[75] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[81] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[82] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[83] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[89] = array('distance' => 0.5, 'sold_within' => 90, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[90] = array('distance' => 0.5, 'sold_within' => 90, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[91] = array('distance' => 0.5, 'sold_within' => 90, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[97] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[98] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[99] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[105] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[106] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[107] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[113] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[114] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[115] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[121] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[122] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[123] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[129] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[130] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[131] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[137] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[138] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[139] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[145] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[146] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[147] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[153] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[154] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[155] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[161] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[162] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[163] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[169] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[170] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[171] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[177] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[178] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[179] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[185] = array('distance' => 0.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[186] = array('distance' => 0.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[187] = array('distance' => 0.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[193] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[194] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[195] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[201] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[202] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[203] = array('distance' => 0.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[209] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[210] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[211] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[217] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[218] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[219] = array('distance' => 0.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[225] = array('distance' => 0.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[226] = array('distance' => 0.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[227] = array('distance' => 0.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[233] = array('distance' => 0.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[234] = array('distance' => 0.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[235] = array('distance' => 0.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);
        
        $LevelFilters[241] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[242] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[243] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);
        
        $LevelFilters[249] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[250] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[251] = array('distance' => 1, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[257] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[258] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[259] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[265] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[266] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[267] = array('distance' => 1, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[273] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[274] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[275] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[281] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[282] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[283] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[289] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[290] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[291] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[297] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[298] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[299] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[305] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[306] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[307] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[313] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[314] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[315] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[321] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[322] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[323] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[329] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[330] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[331] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[337] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[338] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[339] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[345] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[346] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[347] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[353] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[354] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[355] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);

        $LevelFilters[361] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[362] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[363] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[369] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[370] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[371] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[377] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[378] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[379] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);

        $LevelFilters[385] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[386] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[387] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[393] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[394] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[395] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[401] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40);
        $LevelFilters[402] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40);
        $LevelFilters[403] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40);


        $LevelFilters[409] = array('distance' => 1, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[410] = array('distance' => 1, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[411] = array('distance' => 1, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[417] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[418] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[419] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[425] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[426] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'text_mining_exclusion' => true);
        $LevelFilters[427] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'text_mining_exclusion' => true);

        $LevelFilters[433] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 40, 'text_mining_exclusion' => true);
        $LevelFilters[434] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 40, 'text_mining_exclusion' => true);
        $LevelFilters[435] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 40, 'text_mining_exclusion' => true);


        $LevelFilters[441] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'Sold', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[442] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'Sold,Pending', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[443] = array('distance' => 1.5, 'sold_within' => 730, 'status' => 'all', 'square_foot_per' => 100, 'text_mining_exclusion' => true);

        $LevelFilters[449] = array('distance' => 3, 'sold_within' => 730, 'status' => 'Sold', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[450] = array('distance' => 3, 'sold_within' => 730, 'status' => 'Sold,Pending', 'square_foot_per' => 100, 'text_mining_exclusion' => true);
        $LevelFilters[451] = array('distance' => 3, 'sold_within' => 730, 'status' => 'all', 'square_foot_per' => 100, 'text_mining_exclusion' => true);

        return $LevelFilters;
    } 
    public static function GetRLevelFilters()
    {
        $LevelFilters = array();

        $LevelFilters[1] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[2] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[3] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[9] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[10] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[11] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[17] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[18] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[19] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[25] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[26] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[27] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[33] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[34] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15, 'year_built_tolerance' => 15);
        $LevelFilters[35] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15, 'year_built_tolerance' => 15);

        $LevelFilters[41] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[42] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25, 'year_built_tolerance' => 15);
        $LevelFilters[43] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25, 'year_built_tolerance' => 15);

        $LevelFilters[49] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[50] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[51] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[57] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[58] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[59] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[65] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[66] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[67] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[73] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[74] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[75] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[81] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[82] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[83] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[89] = array('distance' => 1.5, 'sold_within' => 180, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[90] = array('distance' => 1.5, 'sold_within' => 180, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[91] = array('distance' => 1.5, 'sold_within' => 180, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[97] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[98] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[99] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[105] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[106] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[107] = array('distance' => 1.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[113] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[114] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[115] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[121] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[122] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[123] = array('distance' => 1.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[129] = array('distance' => 1.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[130] = array('distance' => 1.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[131] = array('distance' => 1.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);
        
        $LevelFilters[137] = array('distance' => 1.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[138] = array('distance' => 1.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[139] = array('distance' => 1.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[145] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[146] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[147] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[153] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[154] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[155] = array('distance' => 2, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[161] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[162] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[163] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[169] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[170] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[171] = array('distance' => 2, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[177] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[178] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[179] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[185] = array('distance' => 2, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[186] = array('distance' => 2, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[187] = array('distance' => 2, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);
        
        $LevelFilters[193] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[194] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[195] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[201] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[202] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[203] = array('distance' => 2.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[209] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[210] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[211] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[217] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[218] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[219] = array('distance' => 2.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[225] = array('distance' => 2.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[226] = array('distance' => 2.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[227] = array('distance' => 2.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[233] = array('distance' => 2.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[234] = array('distance' => 2.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[235] = array('distance' => 2.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[241] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[242] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[243] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[249] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[250] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[251] = array('distance' => 3, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[257] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[258] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[259] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[265] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[266] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[267] = array('distance' => 3, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[273] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[274] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[275] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[281] = array('distance' => 3, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[282] = array('distance' => 3, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[283] = array('distance' => 3, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[289] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[290] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[291] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[297] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[298] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[299] = array('distance' => 3.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[305] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[306] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[307] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[313] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[314] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[315] = array('distance' => 3.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[321] = array('distance' => 3.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[322] = array('distance' => 3.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[323] = array('distance' => 3.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[329] = array('distance' => 3.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[330] = array('distance' => 3.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[331] = array('distance' => 3.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[337] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[338] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[339] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[345] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[346] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[347] = array('distance' => 4, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[353] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[354] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[355] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[361] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[362] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[363] = array('distance' => 4, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[369] = array('distance' => 4, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[370] = array('distance' => 4, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[371] = array('distance' => 4, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[377] = array('distance' => 4, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[378] = array('distance' => 4, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[379] = array('distance' => 4, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[385] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[386] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[387] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[393] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[394] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[395] = array('distance' => 4.5, 'set_style' => 'absolute', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[401] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[402] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[403] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[409] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[410] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[411] = array('distance' => 4.5, 'set_style' => 'relative', 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        $LevelFilters[417] = array('distance' => 4.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 15);
        $LevelFilters[418] = array('distance' => 4.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 15);
        $LevelFilters[419] = array('distance' => 4.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 15);

        $LevelFilters[425] = array('distance' => 4.5, 'sold_within' => 365, 'status' => 'Sold', 'square_foot_per' => 25);
        $LevelFilters[426] = array('distance' => 4.5, 'sold_within' => 365, 'pending_within' => 14, 'status' => 'Sold,Pending', 'square_foot_per' => 25);
        $LevelFilters[427] = array('distance' => 4.5, 'sold_within' => 365, 'contingent_within' => 14, 'pending_within' => 14, 'status' => 'all', 'square_foot_per' => 25);

        return $LevelFilters;
    }

}
class HVUtils{
    public static function CalculateTolerance($Value, $TolerancePercentage)
    {
        return round(($Value / 100) * $TolerancePercentage);
    }
    public static function GetRelativeStyles($CurrentStyle)
    {
        $Condition = array();
        $SingleFamily = array(
            '10 - 1 Story',
            '11 - 1 1/2 Story',
            '12 - 2 Story',
            '13 - Tri-Level',
            '14 - Split Entry',
            '15 - Multi Level',
            '16 - 1 Story w/Bsmnt.',
            '17 - 1 1/2 Stry w/Bsmt',
            '18 - 2 Stories w/Bsmnt',
            'Half Duplex',
            'Modular Home',
            'Residential',
            'Single Family Residence',
            'Villa'
        );
        $Manufactured = array(
            '20 - Manuf-Single Wide', 
            '21 - Manuf-Double Wide', 
            '22 - Manuf-Triple Wide',
            'Manufactured Home - Post 1977'
        );
        $MultiFamily = array(
            '52 - Duplex', 
            '54 - 4-Plex', 
            '55 - 5-9 Units',
            'Duplex',
            'Multi-Family',
            'Quadruplex',
            'Triplex'
        );
        $Condo = array(
            '30 - Condo (1 Level)', 
            '31 - Condo (2 Levels)', 
            '33 - Co-op',
            '34 - Condo (3 Levels)',
            'Condo - Hotel',
            'Condominium'
        );

        if (in_array(trim($CurrentStyle), $SingleFamily)) {
            $Condition = $SingleFamily;
        } else if (in_array(trim($CurrentStyle), $Manufactured)) {
            $Condition = $Manufactured;
        } else if (in_array(trim($CurrentStyle), $MultiFamily)) {
            $Condition = $MultiFamily;
        } else if (in_array(trim($CurrentStyle), $Condo)) {
            $Condition = $Condo;
        } else
            $Condition = array(trim($CurrentStyle));
        return $Condition;
    }
    private static $msCommentsCondition;
    public static function GetCommentExclusion() {
        if (self::$msCommentsCondition == null) {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('textmining_master'));
            $Obj->AddFlds(array('phrase'));
            $PhrasesArr = $Obj->GetMultiple();

            self::$msCommentsCondition = array();
            foreach ($PhrasesArr as $Item)
                self::$msCommentsCondition[] = trim(strtolower($Item['phrase']));
        }
        return self::$msCommentsCondition;
    }

}
class HVFilter
{
    private $Filter;
    private $Property;

    private $YearLow;
    private $YearHigher;

    private $SquareFootLow = 0;
    private $SquareFootHigh = 0;
    private $SoldPriceLow = 0;
    private $SoldPriceHigh = 0;

    public function distance($Item)
    {
        return $Item['distance'] <= $this->Filter['distance'];
    }

    public function yearBuilt($Item)
    {
        return $Item['year_built'] >= $this->YearLow && $Item['year_built'] <= $this->YearHigher;
    }

    public function squareFoot($Item)
    {
        return $Item['square_foot'] >= $this->SquareFootLow && $Item['square_foot'] <= $this->SquareFootHigh;
    }

    public function status($Item)
    {
        if (strtolower($this->Filter['status']) == 'sold') {
            return (strtolower($Item['status']) == 'sold');
        } else if (strtolower($this->Filter['status']) == 'sold,pending' || strtolower($this->Filter['status']) == 'pending,sold') {
            return (strtolower($Item['status']) != 'active' && strtolower($Item['status']) != 'contingent');
        }
        return true;
    }

    public function soldPrice($Item)
    {
        if ($this->SoldPriceLow > 0 && $this->SoldPriceHigh > 0) {
            if (strtolower($Item['status']) == 'sold')
                return $Item['sold_price'] >= $this->SoldPriceLow && $Item['sold_price'] <= $this->SoldPriceHigh;
            else
                return $Item['list_price'] >= $this->SoldPriceLow && $Item['list_price'] <= $this->SoldPriceHigh;
        }
        return true;
    }

    public function soldWithin($Item)
    {
        if ($Item['status'] == 'Sold') {
            return ($Item['sold_within'] <= $this->Filter['sold_within']);
        }
        return true;
    }

    public function absoluteStyle($Item)
    {
        return trim(strtolower($Item['style'])) == trim(strtolower($this->Property['style']));
    }
    
    public function relativeStyle($Item)
    {
        $RelativeStyles = HVUtils::GetRelativeStyles($this->Property['style']);
        return in_array( trim($Item['style']),  $RelativeStyles);
    }

    public function excludePublicComments($Item)
    {
        $PublicComments = strtolower($Item['public_comments']);
        $Comments = HVUtils::GetCommentExclusion();
        foreach ($Comments as $Comment) {
            if (!(strpos($PublicComments, $Comment) === false)) {
                return false;
            }
        }
        return true;
    }
   
    
    public function setFilterParameters($Filter)
    {
        $this->Filter = $Filter;
    }

    public function setSubjectProperty($Property)
    {
        $this->Property = $Property;

        if (isset($this->Filter['year_built_tolerance'])) {
            $this->YearLow = $Property['year_built'] - $this->Filter['year_built_tolerance'];
            $this->YearHigher = $Property['year_built'] + $this->Filter['year_built_tolerance'];
        }

        $SquareFootTolerance = HVUtils::CalculateTolerance($Property['square_foot'], $this->Filter['square_foot_per']);
        $this->SquareFootLow = $Property['square_foot'] - $SquareFootTolerance;
        $this->SquareFootHigh = $Property['square_foot'] + $SquareFootTolerance;

        if (isset($this->Filter['sold_price_per']) && $this->Filter['sold_price_per'] > 0) {
            $SoldPriceTolerance = HVUtils::CalculateTolerance($Property['sold_price'], $this->Filter['sold_price_per']);
            $this->SoldPriceLow = $Property['sold_price'] - $SoldPriceTolerance;
            $this->SoldPriceHigh = $Property['sold_price'] + $SoldPriceTolerance;
        } else if (isset($this->Filter['sold_price_low']) && isset($this->Filter['sold_price_high']) && $this->Filter['sold_price_low'] > 0 && $this->Filter['sold_price_high'] > 0) {
            $this->SoldPriceLow = $this->Filter['sold_price_low'];
            $this->SoldPriceHigh = $this->Filter['sold_price_high'];
        }
    }
}
?>