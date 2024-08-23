<?php

class EstimatedPrice{
    public static function GetMappedPropertiesWithInbestments()
    {
        $Properties = self::PropertiesToBeMappedWithInbestmentsRecords();
        echo '<br>';
        echo 'MappedPropertiesWithInbestments::<pre>';
        print_r($Properties); 
       
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($Properties,CONFIG_IS_MAPPING_COMPLETED,'P');
      
        if(!empty($Properties)){
            foreach ($Properties as $Property) {
                $PropertyIDRes = self::FindInbestmentsPropertyID($Property['insights_property_id'], $Property['property_address'], $Property['property_city'], $Property['property_state'], $Property['unit_number'], $Property['property_zipcode']);
                echo '$PropertyIDRes::###:'; 
                print_r($PropertyIDRes);
                self::UpdateInsightsMainAfterUSPSValidation($PropertyIDRes, $Property['insights_property_id'],CONFIG_MAPPED_PROPERTIES_WITH_INBESTMENTS);    
            }
        }
        
    }
    public static function UpdateInsightsMain($InsightsPropertyID, $Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_main'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->Update();
    }
    public static function UpdateInsightsMainAfterUSPSValidation($PropertyIDRes, $insightsPropertyId,$CronFunctionName){
     
        if (count($PropertyIDRes) && isset($PropertyIDRes['id']) && $PropertyIDRes['id'] > 0)
        {
            
            
            self::UpdateInsightsMain($insightsPropertyId, array(
                'inbestments_property_id' => $PropertyIDRes['id'], 
                'checked_in_inbestments' => 'Y', 
                'bedroom' => $PropertyIDRes['bedroom_count'], 
                'bedroom_src' => 'property_details_mls', 
                'bathroom' => $PropertyIDRes['bathroom_count'],
                'bathroom_src' => 'property_details_mls',  
                'square_foot' => $PropertyIDRes['square_foot'],
                'square_foot_src' => 'property_details_mls',  
                'year_built' => $PropertyIDRes['year_built'],
                'year_built_src' => 'property_details_mls',  
                'purchase_price' => $PropertyIDRes['sold_price'],
                'purchase_price_src' => 'property_details_mls',  
                'purchase_date' => $PropertyIDRes['sold_date'],
                'purchase_date_src' => 'property_details_mls',
                'latitude' => $PropertyIDRes['latitude'],
                'latitude_source' => 'property_details_mls',
                'longitude' => $PropertyIDRes['longitude'],
                'longitude_source' => 'property_details_mls',
                
                )
            );
            
            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $insightsPropertyId, 
                'cron_function_status_flag' => MlsNumberReceived, 'checked_in_inbestments' => 'Y', 'month' => date('m'), 'year' => date('Y') );  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($insightsPropertyId, CONFIG_IS_MAPPING_COMPLETED,'Y');
           // array('bedroom', 'bathroom', 'square_foot', 'year_built', 'purchase_price', 'purchase_date')
            
            $AuditHistoryParam1 = array( 
                array( 'changed_column_name' => 'bedroom',  'column_new_value' => $PropertyIDRes['bedroom_count']), 
                array( 'changed_column_name' => 'bathroom', 'column_new_value' => $PropertyIDRes['bathroom_count']),
                array( 'changed_column_name' => 'square_foot', 'column_new_value' => $PropertyIDRes['square_foot']),
                array( 'changed_column_name' => 'year_built', 'column_new_value' => $PropertyIDRes['year_built']),
                array( 'changed_column_name' => 'purchase_price', 'column_new_value' => $PropertyIDRes['sold_price']),
                array( 'changed_column_name' => 'purchase_date', 'column_new_value' => $PropertyIDRes['sold_date']),
                array( 'changed_column_name' => 'latitude', 'column_new_value' => $PropertyIDRes['latitude']),
                array( 'changed_column_name' => 'longitude', 'column_new_value' => $PropertyIDRes['longitude']),
            ); 
           
            $AuditHistoryParam = array(
                'table_name' => 'property_details_mls', 
                'table_primary_key_name' => 'id',
                'table_primary_key_value' => $PropertyIDRes['id'], 
                'insights_property_id' => $insightsPropertyId,
                'column_source' => 'cron_property_mapping',
                'property_details'=> $AuditHistoryParam1
            );
            echo '<br>';
            echo 'AuditHistoryParam::<pre>';
            print_r($AuditHistoryParam); 
            $InsertInsightsAuditHistoryArray = Common::InsightsAuditHistoryArray($AuditHistoryParam);
             
            
            

        }
        else{
            self::UpdateInsightsMain($insightsPropertyId, array('checked_in_inbestments' => 'Y'));
            
            if($CronFunctionName==CONFIG_MAPPED_PROPERTIES_WITH_INBESTMENTS){
                $CronFunctionStatusFlag=AddressNotFoundInMLS;
            }else if($CronFunctionName==CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API OR $CronFunctionName==CONFIG_FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API ) 
            {
                $CronFunctionStatusFlag=AddressNotFoundAfterValidateUSPS;
            }
            $Parms = array('cron_function_name' => $CronFunctionName, 'insights_property_id' => $insightsPropertyId, 
            'cron_function_status_flag' => AddressNotFoundInMLS, 'checked_in_inbestments' => 'Y',  'month' => date('m'), 'year' => date('Y'));  
            $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);
      }
                
        
    }
    
    private static function PropertiesToBeMappedWithInbestmentsRecords()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id, property_address, property_city, property_state, unit_number, property_zipcode FROM insights_main 
        WHERE ( inbestments_property_id IS NULL OR inbestments_property_id = 0 OR inbestments_property_id ='') AND checked_in_inbestments!='Y'
        AND property_address NOT LIKE '123 Main Street' 
        ".CONFIG_PROPERTY_CONDITION." ".AUTOMATION_CONDITION."
        AND insights_property_id NOT IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf 
        ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_MAPPED_PROPERTIES_WITH_INBESTMENTS."' AND  icf.cron_function_frequency='OneTime' )
        ORDER BY insights_property_id DESC
        LIMIT 10"; 
        echo '<BR>PropertiesToBeMappedWithInbestmentsRecords<pre>'; 
        print_r($Query); 
        return $Obj->GetQuery($Query);        
    }
    public static function FindInbestmentsPropertyID($InsightsPropertyID, $Address, $City, $State, $UnitNumber, $ZipCode)
    {
        print_r($InsightsPropertyID.' Add '.$Address.' City '.$City.' State '.$State.' Unit '.$UnitNumber.' Zip  '.$ZipCode);
        //             2               Add 456 Elm St  City Chicago   State     IL        Unit              Zip     60601
        $searchTxtLower = trim(strtolower($Address));
        $searchTxtLowerArr = explode(' ', $searchTxtLower);
        echo '$searchTxtLower';
        print_r($searchTxtLower);
        echo '$searchTxtLowerArr';
        print_r($searchTxtLowerArr);

        $long = self::GetFullForm();
        $short = self::GetShortTerms();
        $dirLong = self::GetDirLong();
        $dirShort = self::GetDirShort();

        /* All short format */
        for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
            for ($j = 0; $j < count($long); $j++) {
                if (trim($searchTxtLowerArr[$i]) == trim($long[$j])) {

                    $searchTxtLowerArr[$i] = $short[$j];
                }
            }
            for ($j = 0; $j < count($dirLong); $j++) {
                if (trim($searchTxtLowerArr[$i]) == trim($dirLong[$j])) {
                    $searchTxtLowerArr[$i] = $dirShort[$j];
                }
            }
        }

        /*Combine All format*/
        echo '$searchTxtLowerArr';
        print_r($searchTxtLowerArr);
        $allFormat = [join(' ', $searchTxtLowerArr)];

        print_r($allFormat);
        for ($i = 0; $i < count($searchTxtLowerArr); $i++) {
            $temp = $searchTxtLowerArr;
            $tempFull = $searchTxtLowerArr;
            $tempDot = $searchTxtLowerArr;
            $tempComma = $searchTxtLowerArr;
            for ($j = 0; $j < count($short); $j++) {
                if (is_string(trim($temp[$i]))){
                    if (trim($temp[$i]) == trim($short[$j])) {
                        $tempFull[$i] = $long[$j];
                        array_push($allFormat, join(' ', $tempFull));

                        if (strpos($temp[$i], ".") !== false) {
                            $tempDot[$i] = str_replace(".", "", $temp[$i]);
                            array_push($allFormat, join(' ', $tempDot));
                        }else{                            
                            $tempDot[$i] = $temp[$i].".";
                            array_push($allFormat, join(' ', $tempDot));
                        }

                        if (strpos($temp[$i], ",") !== false) {
                            $tempComma[$i] = str_replace(",", "", $temp[$i]);
                            array_push($allFormat, join(' ', $tempComma));                            
                        }else{
                            $tempComma[$i] = $temp[$i].",";
                            array_push($allFormat, join(' ', $tempComma));
                        }
                        break;
                    }
                }
            }
         //   print_r($allFormat);
            for ($j = 0; $j < count($dirShort); $j++) {
                if (is_string(trim($temp[$i]))){
                    if (trim($temp[$i]) == trim($dirShort[$j])) {
                        $tempFull[$i] = $dirLong[$j];
                        array_push($allFormat, join(' ', $tempFull));

                        if (strpos($temp[$i], ".") !== false) {
                            $tempDot[$i] = str_replace(".", "", $temp[$i]);
                            array_push($allFormat, join(' ', $tempDot));
                        }else{
                            $tempDot[$i] = $temp[$i].".";
                            array_push($allFormat, join(' ', $tempDot));                            
                        }

                        if (strpos($temp[$i], ",") !== false) {
                            $tempComma[$i] = str_replace(",", "", $temp[$i]);
                            array_push($allFormat, join(' ', $tempComma));
                        }else{
                            $tempComma[$i] = $temp[$i].",";
                            array_push($allFormat, join(' ', $tempComma));                            
                        }
                        break;
                    }
                }
            }
        //    print_r($allFormat);
            for ($k = $i; $k < count($searchTxtLowerArr); $k++) {
                for ($j = 0; $j < count($short); $j++) {
                    if (is_string(trim($temp[$k]))){
                        if (trim($temp[$k]) == trim($short[$j])) {
                            $tempFull[$k] = $long[$j];
                            array_push($allFormat, join(' ', $tempFull));

                            if (strpos($temp[$k], ".") !== false) {
                                $tempDot[$k] = str_replace(".", "", $temp[$k]);
                                array_push($allFormat, join(' ', $tempDot));
                            }else{
                                $tempDot[$k] = $temp[$k].".";
                                array_push($allFormat, join(' ', $tempDot));
                            }
    
                            if (strpos($temp[$k], ",") !== false) {
                                $tempComma[$k] = str_replace(",", "", $temp[$k]);
                                array_push($allFormat, join(' ', $tempComma));
                            }else{
                                $tempComma[$k] = $temp[$k].",";
                                array_push($allFormat, join(' ', $tempComma));                                
                            }
                            break;
                        }
                    }
                }
             //   print_r($allFormat);
                for ($j = 0; $j < count($dirShort); $j++) {
                    if (is_string(trim($temp[$k]))){
                        if (trim($temp[$k]) == trim($dirShort[$j])) {
                            $tempFull[$k] = $dirLong[$j];
                            array_push($allFormat, join(' ', $tempFull));

                            if (strpos($temp[$k], ".") !== false) {
                                $tempDot[$k] = str_replace(".", "", $temp[$k]);
                                array_push($allFormat, join(' ', $tempDot));
                            }else{
                                $tempDot[$k] = $temp[$k].".";
                                array_push($allFormat, join(' ', $tempDot));
                                
                            }

                            if (strpos($temp[$k], ",") !== false) {
                                $tempComma[$i] = str_replace(",", "", $temp[$i]);
                                array_push($allFormat, join(' ', $tempComma));
                            }else{
                                $tempComma[$k] = $temp[$k].",";
                                array_push($allFormat, join(' ', $tempComma));
                                
                            }
                            break;
                        }
                    }
                }
              //  print_r($allFormat);
                for ($l = $k; $l < count($searchTxtLowerArr); $l++) {
                    for ($j = 0; $j < count($short); $j++) {
                        if (is_string(trim($temp[$l]))){
                            if (trim($temp[$l]) == trim($short[$j])) {
                                $tempFull[$l] = $long[$j];
                                array_push($allFormat, join(' ', $tempFull));
                                
                                if (strpos($temp[$l], ".") !== false) {
                                    $tempDot[$l] = str_replace(".", "", $temp[$l]);
                                    array_push($allFormat, join(' ', $tempDot));
                                }else{
                                    $tempDot[$l] = $temp[$l].".";
                                    array_push($allFormat, join(' ', $tempDot));
                                    
                                }
        
                                if (strpos($temp[$l], ",") !== false) {
                                    $tempComma[$l] = str_replace(",", "", $temp[$l]);
                                    array_push($allFormat, join(' ', $tempComma));
                                }else{
                                    $tempComma[$l] = $temp[$l].",";
                                    array_push($allFormat, join(' ', $tempComma));
                                    
                                }
                                break;
                            }
                        }
                    }
                  //  print_r($allFormat);
                    for ($j = 0; $j < count($dirShort); $j++) {
                        if (is_string(trim($temp[$l]))){
                            if (trim($temp[$l]) == trim($dirShort[$j])) {
                                $tempFull[$l] = $dirLong[$j];
                                array_push($allFormat, join(' ', $tempFull));
                                
                                if (strpos($temp[$l], ".") !== false) {
                                    $tempDot[$l] = str_replace(".", "", $temp[$l]);
                                    array_push($allFormat, join(' ', $tempDot));
                                }else{
                                    $tempDot[$l] = $temp[$l].".";
                                    array_push($allFormat, join(' ', $tempDot));
                                    
                                }
        
                                if (strpos($temp[$l], ",") !== false) {
                                    $tempComma[$l] = str_replace(",", "", $temp[$l]);
                                    array_push($allFormat, join(' ', $tempComma));
                                }else{
                                    $tempComma[$l] = $temp[$l].",";
                                    array_push($allFormat, join(' ', $tempComma));
                                    
                                }
                                break;
                            }
                        }
                    }
                   // print_r($allFormat);
                }
            }
        }
        print_r($allFormat);

        $allFormat = array_unique($allFormat);
        print_r($allFormat);
         //             2               Add 456 Elm St  City Chicago   State     IL        Unit              Zip  
        
        $Obj = new SqlManager();
        $Obj->AddTbls(array('property_details_mls'));
        $Obj->AddFlds(array('id', 'address', 'city_name', 'state_code', 'unit_number', "IF(status = 'Sold', sold_date, mls_updated_date) transactional_date", 'bedroom_count', 'bathroom_count', 'square_foot', 'year_built', 'sold_date', 'sold_price', 'latitude', 'longitude'));
        $Obj->AddFldCond('LOWER(city_name)', strtolower($City));
        $Obj->AddFldCond('LOWER(state_code)', strtolower($State));
        $Obj->AddFldCond('LOWER(address)', trim(strtolower($Address . ' ')), '=', 'AND', '(');

        $numItems = count($allFormat);
        $i = 0;
         /*
            [0] => 456 elm st
            [1] => 456 elm street
            [2] => 456 elm st.
             [3] => 456 elm st,
         */
        foreach ($allFormat as $addrValue) {
            if (++$i === $numItems) {
                $Obj->AddFldCond('LOWER(address)', $addrValue , '=', 'OR', '', ')');
            } else
                $Obj->AddFldCond('LOWER(address)', $addrValue , '=', 'OR');
        }
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetShortTerms(), self::GetFullForm(), strtolower($Address))).'%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetFullForm(), self::GetShortTerms(), strtolower($Address))).'%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetDirShort(), self::GetDirLong(), strtolower($Address))).'%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetDirLong(), self::GetDirShort(), strtolower($Address))).'%', 'LIKE', 'OR');

        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetShortTerms(), self::GetFullForm(), strtolower($Address . ' '))) . '%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetFullForm(), self::GetShortTerms(), strtolower($Address . ' '))) . '%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetDirShort(), self::GetDirLong(), strtolower($Address . ' '))) . '%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(self::GetDirLong(), self::GetDirShort(), strtolower($Address . ' '))) . '%', 'LIKE', 'OR');

        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(array_merge(self::GetFullForm(), self::GetDirLong()), array_merge(self::GetShortTerms(), self::GetDirShort()), strtolower($Address . ' '))) . '%', 'LIKE', 'OR');
        // $Obj->AddFldCond('LOWER(address)', trim(str_replace(array_merge(self::GetShortTerms(), self::GetDirShort()), array_merge(self::GetFullForm(), self::GetDirLong()), strtolower($Address . ' '))) . '%', 'LIKE', 'OR', '', ')');

        if (isset($UnitNumber) && $UnitNumber != '' && $UnitNumber !== '0' && $UnitNumber !== 0)
            $Obj->AddFldCond('LOWER(unit_number)', strtolower($UnitNumber));

        if ($ZipCode > 0)
            $Obj->AddFldCond('zip_code', $ZipCode);

        $Obj->AddOrderFlds('transactional_date', 'DESC');
        $Res = $Obj->GetMultiple();
        print_r($Res);
        /* if (count($Res) > 1) {
            $CanMap = false;
            foreach ($Res as $Index => $Item) {
                if (isset($Res[$Index]) && isset($Res[$Index + 1]))
                    $CanMap = self::ComparePropertyByAddress($Res[$Index], $Res[$Index + 1]);
            }
            if (!$CanMap) {
                self::UpdateInsightsMain($InsightsPropertyID, array('has_multi_match' => 'Y'));
                return array();
            } else
                return $Res[0];
        } else */ if (count($Res) >= 1) {
            echo 'Find@111';
            print_r($Res[0]);
            return $Res[0];
        } else {
            return array();
        }
    }
    private static function GetShortTerms()
    {
        return array(
            'ave',
            'ave.','ave,',
            'blvd',
            'blvd.','blvd,',
            'br',
            'br.','br,',
            'cyn',
            'cyn.','cyn,',
            'ctr',
            'ctr.','ctr,',
            'cir',
            'cir.','cir,',
            'ct',
            'ct.','ct,',
            'cres',
            'cres.','cres,',
            'dr',
            'dr.','dr,',
            'expwy',
            'expwy.','expwy,',
            'fwy',
            'fwy.','fwy,',
            'hwy',
            'hwy.','hwy,',
            'info',
            'info.','info,',
            'intl',
            'intl.','intl,',
            'isl',
            'isl.','isl,',
            'jct',
            'jct.','jct,',
            'ln',
            'ln.','ln,',
            'lk',
            'lk.','lk,',
            'lp',
            'lp.','lp,',
            'mt',
            'mt.','mt,',
            'mtn',
            'mtn.','mtn,',
            'natl',
            'natl.','natl,',
            'pkwy',
            'pkwy.','pkwy,',
            'pl',
            'pl.','pl,',
            'plz',
            'plz.','plz,',
            'pt',
            'pt.','pt,',
            'r',
            'r.','r,',
            'rd',
            'rd.','rd,',
            'rte',
            'rte.','rte,',
            'sq',
            'sq.','sq,',
            'st',
            'st.','st,',
            'ter',
            'ter.','ter,',
            'thwy',
            'thwy.','thwy,',
            'tr',
            'tr.','tr,',
            'trl',
            'trl.','trl,',
            'tpk',
            'tpk.','tpk,',
            'wy',
            'wy.','wy,',
        );
    }

    private static function GetFullForm()
    {
        return array(
            'avenue',
            'avenue','avenue',
            'boulevard',
            'boulevard','boulevard',
            'bridge',
            'bridge','bridge',
            'canyon',
            'canyon','canyon',
            'center',
            'center','center',
            'circle',
            'circle','circle',
            'court',
            'court','court',
            'crescent',
            'crescent','crescent',
            'drive',
            'drive','drive',
            'expressway',
            'expressway','expressway',
            'freeway',
            'freeway','freeway',
            'highway',
            'highway','highway',
            'information',
            'information','information',
            'international',
            'international','international',
            'island',
            'island','island',
            'junction',
            'junction','junction',
            'lane',
            'lane','lane',
            'lake',
            'lake','lake',
            'loop',
            'loop','loop',
            'mount',
            'mount','mount',
            'mountain',
            'mountain','mountain',
            'national',
            'national','national',
            'parkway',
            'parkway','parkway',
            'place',
            'place','place',
            'plaza',
            'plaza','plaza',
            'port',
            'port','port',
            'river',
            'river','river',
            'road',
            'road','road',
            'route',
            'route','route',
            'square',
            'square','square',
            'street',
            'street','street',
            'terrace',
            'terrace','terrace',
            'thruway',
            'thruway','thruway',
            'trail',
            'trail','trail',
            'trail',
            'trail','trail',
            'turnpike',
            'turnpike','turnpike',
            'way',
            'way','way'
        );
    }

    private static function GetDirShort()
    {
        return array(
            'e',
            'e.','e,',
            'n',
            'n.','n,',
            'ne',
            'ne.','ne,',
            'nw',
            'nw.','nw,',
            's',
            's.','s,',
            'se',
            'se.','se,',
            'sw',
            'sw.','sw,',
            'w',
            'w.','w,'
        );
    }

    private static function GetDirLong()
    {
        return array(
            'east',
            'east','east',
            'north',
            'north','north',
            'northeast',
            'northeast','northeast',
            'northwest',
            'northwest','northwest',
            'south',
            'south','south',
            'southeast',
            'southeast','southeast',
            'southwest',
            'southwest','southwest',
            'west',
            'west', 'west'
        );
    }
    public static function CallFetchPropertiesToValidateUSPSAPI ($FetchPropertiesToValidateWithUSPSAPIActive)
    {
        if($FetchPropertiesToValidateWithUSPSAPIActive){
            $Res = self::FetchPropertiesToValidateWithUSPSAPI();
            // Cron-Function-Complete-Status
           // print_r($Res);
            
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($Res,CONFIG_IS_MAPPING_COMPLETED,'P');
             echo 'FetchPropertiesToValidateWithUSPSAPIActive::<pre>';
             print_r($Res);
            
            
            foreach ($Res as $Item) {
                $Row =self::CallUSPS($Item);
                if (count($Row) > 1) {
                    $Row['insights_property_id'] = $Item['insights_property_id'];
                    self::InsertEstUSPS($Row);
                    // passed unit_no = '' as it is already concatinated in address2 from USPS.
                    $PropertyIDRes = self::FindInbestmentsPropertyID($Row['insights_property_id'],$Row['address2'],$Row['city'],$Row['state'],'',$Row['zip5']);
                   
                    if(count($PropertyIDRes) == 0){
                        self::InsertAddressIssueInInsightIssues($Row['insights_property_id']);
                    }
                    self::UpdateInsightsMainAfterUSPSValidation($PropertyIDRes, $Row['insights_property_id'],CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API);    
                } else if (count($Row) == 1) {
                    if ($Row['error']) {
                        // Insert record in tbl_insights_issues table when address not found in USPS
                        self::InsertAddressIssueInInsightIssues($Item['insights_property_id']);
                        $Parms = array('cron_function_name' => CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API, 'insights_property_id' => $Item['insights_property_id'], 
                        'cron_function_status_flag' => AddressNotFoundAfterValidateUSPS,  'month' => CURRENT_MONTH, 'year' => CURRENT_YEAR);  
                        $UpdateFetchPropertiesToValidateWithUSPSAPI=Common::InsertData('insights_cron_function_status', $Parms,false);
    
                    }
                }
    
            }
            
        }
      
    }
    public static function  CallUSPS($Item)
    {
        $Row = array();
        $AddressArray = self::APICall($Item);

        if ($AddressArray->Address) {
            $Address = $AddressArray->Address;

            if (count($Address)) {
                if (isset($Address->Address2)) {
                    $Row['address2'] = $Address->Address2->__toString();
                }
                if (isset($Address->City)) {
                    $Row['city'] = $Address->City->__toString();
                }
                if (isset($Address->State)) {
                    $Row['state'] = $Address->State->__toString();
                }
                if (isset($Address->Zip5)) {
                    $Row['zip5'] = $Address->Zip5->__toString();
                }
                if (isset($Address->Zip4)) {
                    $Row['zip4'] = $Address->Zip4->__toString();
                }
                if (isset($Address->DeliveryPoint)) {
                    $Row['deliverypoint'] = $Address->DeliveryPoint->__toString();
                }
                if (isset($Address->CarrierRoute)) {
                    $Row['carrierroute'] = $Address->CarrierRoute->__toString();
                }
                if (isset($Address->DPVConfirmation)) {
                    $Row['dpvconfirmation'] = $Address->DPVConfirmation->__toString();
                }
                if (isset($Address->DPVCMRA)) {
                    $Row['dpvcmra'] = $Address->DPVCMRA->__toString();
                }
                if (isset($Address->DPVFootnotes)) {
                    $Row['dpvfootnotes'] = $Address->DPVFootnotes->__toString();
                }
                if (isset($Address->Business)) {
                    $Row['business'] = $Address->Business->__toString();
                }
                if (isset($Address->CentralDeliveryPoint)) {
                    $Row['centraldeliverypoint'] = $Address->CentralDeliveryPoint->__toString();
                }
                if (isset($Address->Vacant)) {
                    $Row['vacant'] = $Address->Vacant->__toString();
                }
                if (isset($Address->Footnotes)) {
                    $Row['footnotes'] = $Address->Footnotes->__toString();
                }
                if (isset($Address->Address2Abbreviation)) {
                    $Row['address2abbreviation'] = $Address->Address2Abbreviation->__toString();
                }
                if (isset($Address->DPVFalse)) {
                    $Row['dpvfalse'] = $Address->DPVFalse->__toString();
                }
                if (isset($Address->CityAbbreviation)) {
                    $Row['cityabbreviation'] = $Address->CityAbbreviation->__toString();
                }
                if (isset($Address->Error)) {
                    $Row['error'] = json_encode($Address->Error);
                }
            }
        }

        return $Row;
    }


    public static function APICall($Data)
    {
        // $APIURL = "http://production.shippingapis.com/ShippingApi.dll?API=Verify&XML=";
        $APIURL = "https://secure.shippingapis.com/ShippingApi.dll?API=Verify&XML=";

        $PayLoad = '';
        $PayLoad .= '<AddressValidateRequest USERID="893INBES7453" PASSWORD="804XF40YA344">';

        $PayLoad .= '<Revision>1</Revision>';

        $PayLoad .= '<Address ID="0">';

        $PayLoad .= '<Address1></Address1>';

        $PayLoad .= '<Address2>' . $Data['property_address'] . ' ' . $Data['unit_number'] . '</Address2>';

        $PayLoad .= '<City>' . $Data['property_city'] . '</City>';

        $PayLoad .= '<State>' . $Data['property_state'] . '</State>';

        if ($Data['property_zipcode'] != null && $Data['property_zipcode'] != '')
            $PayLoad .= '<Zip5>' . $Data['property_zipcode'] . '</Zip5>';
        else
            $PayLoad .= '<Zip5></Zip5>';

        $PayLoad .= '<Zip4></Zip4>';

        $PayLoad .= '</Address>';

        $PayLoad .= '</AddressValidateRequest>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $APIURL . urlencode($PayLoad));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $Res = curl_exec($ch);
        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);

        if (isset($error_msg)) {
            var_dump($error_msg);
        }

        return simplexml_load_string($Res);
    }
    public static function FetchPropertiesToValidateWithUSPSAPI()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id, property_address, property_city, property_state, unit_number, property_zipcode FROM insights_main 
        WHERE ( inbestments_property_id IS NULL OR inbestments_property_id = 0 OR inbestments_property_id ='') AND checked_in_inbestments='Y'
        AND checked_in_usps='N' AND has_multi_match!='Y'
        ".CONFIG_PROPERTY_CONDITION."".AUTOMATION_CONDITION."
        AND insights_property_id NOT IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API."' AND  icf.cron_function_frequency='OneTime')
        ORDER BY insights_property_id DESC
        LIMIT 10"; 
   
        return $Obj->GetQuery($Query); 

    }

    public static function InsertEstUSPS($Row)
    {
        $Check = self::CheckUSPS($Row['insights_property_id']);

        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_address_usps'));
        $Obj->AddInsrtFlds($Row);

        if (count($Check)) {
            $Obj->AddFldCond('insights_property_id', $Row['insights_property_id']);
            $Obj->Update();
        } else
            $Obj->InsertSingle();

        self::UpdateInsightsMain($Row['insights_property_id'], array('checked_in_usps' => 'Y'));
    }
    public static function InsertAddressIssueInInsightIssues ($insights_property_id) {
        $Issues[] = array(
            'insights_property_id' => $insights_property_id,
            'issues_present' => 'Y',
            'issue_description' => 'Address not found',
            'issue_found_date' => date(DB_DATETIME_FORMAT),
            'is_mandatory_for_home_value' => 'Y',
            'modified_date' => date(DB_DATETIME_FORMAT),
            'modified_by_user' => 0
        );
        SIFlagIssues::CheckInsightIssues($Issues);
    }  
    private static function CheckUSPS($ID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_address_usps'));
        $Obj->AddFlds(array('insights_property_id'));
        $Obj->AddFldCond('insights_property_id', $ID);
        return $Obj->GetSingle();
    }
    public static function CallFetchMissingMortgagePropsToValidateWithUSPSAPI($FetchMissingMortgagePropsToValidateWithUSPSAPIActive)
    {
        if($FetchMissingMortgagePropsToValidateWithUSPSAPIActive){
            $MPRes = self::FetchMissingMortgagePropsToValidateWithUSPSAPI();
  
            $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($MPRes,CONFIG_IS_MAPPING_COMPLETED,'P');
    
            foreach ($MPRes as $Item) {
                $Row = self::CallUSPS($Item);
                if (count($Row) > 1) {
                    $Row['insights_property_id'] = $Item['insights_property_id'];
                    self::InsertEstUSPS($Row);
                    self::UpdateInsightsMain($Item['insights_property_id'], array('address_checked_for_mortgage' => 'Y'));
  
                    $PropertyIDRes = self::FindInbestmentsPropertyID($Row['insights_property_id'],$Row['address2'],$Row['city'],$Row['state'],'',$Row['zip5']);
                    if(count($PropertyIDRes) == 0){
                        self::InsertAddressIssueInInsightIssues($Row['insights_property_id']);
                    }
                    self::UpdateInsightsMainAfterUSPSValidation($PropertyIDRes, $Row['insights_property_id'],CONFIG_FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API);   
                } else if (count($Row) == 1) {
                    if ($Row['error']) {
     
                        self::InsertAddressIssueInInsightIssues($Item['insights_property_id']);
                        $Parms = array('cron_function_name' => CONFIG_FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API, 'insights_property_id' => $Item['insights_property_id'], 
                        'cron_function_status_flag' => AddressNotFoundAfterValidateUSPS,  'month' => CURRENT_MONTH, 'year' => CURRENT_YEAR);  
                        $UpdateFetchPropertiesToValidateWithUSPSAPI=Common::InsertData('insights_cron_function_status', $Parms,false);                    
                    }
                }
            }   
            
        }
    }
    
    public static function FetchMissingMortgagePropsToValidateWithUSPSAPI()
    {
        $Obj = new SqlManager();
        $Query = "SELECT insights_property_id, property_address, property_city, property_state, unit_number, property_zipcode FROM insights_main 
        WHERE ( inbestments_property_id IS NOT NULL OR inbestments_property_id > 0) AND checked_in_inbestments='Y'
        AND checked_in_usps='N' AND has_multi_match!='Y' AND mortgage_fetched_from_attom='N' AND address_checked_for_mortgage='N'
        ".CONFIG_PROPERTY_CONDITION."".AUTOMATION_CONDITION."
        AND insights_property_id NOT IN (SELECT insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API."' AND  icf.cron_function_frequency='OneTime' )
        ORDER BY insights_property_id DESC
        LIMIT 10"; 
      
        return $Obj->GetQuery($Query);       
    }
    public static function MappedUSPSPropertiesWithInbestments()
    {
        $Properties = self::USPSPropertiesToBeMappedWithInbestments();
 
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($Properties,CONFIG_IS_MAPPING_COMPLETED,'P');        
        foreach ($Properties as $Property) {
            $PropertyIDRes = self::FindInbestmentsPropertyID($Property['insights_property_id'], $Property['property_address'], $Property['property_city'], $Property['property_state'], 0, $Property['property_zipcode']);
            echo 'PropertyIDRes:: '; 
            print_r($PropertyIDRes);
            if (count($PropertyIDRes) && isset($PropertyIDRes['id']) && $PropertyIDRes['id'] > 0){
                self::UpdateInsightsMain($Property['insights_property_id'], array(
                    'inbestments_property_id' => $PropertyIDRes['id'], 
                    'checked_in_usps' => 'Y',
                    'bedroom' => $PropertyIDRes['bedroom_count'], 
                    'bedroom_src' => 'property_details_mls', 
                    'bathroom' => $PropertyIDRes['bathroom_count'],
                    'bathroom_src' => 'property_details_mls',  
                    'square_foot' => $PropertyIDRes['square_foot'],
                    'square_foot_src' => 'property_details_mls',  
                    'year_built' => $PropertyIDRes['year_built'],
                    'year_built_src' => 'property_details_mls',  
                    'purchase_price' => $PropertyIDRes['sold_price'],
                    'purchase_price_src' => 'property_details_mls',  
                    'purchase_date' => $PropertyIDRes['sold_date'],
                    'purchase_date_src' => 'property_details_mls', 
                    'latitude' => $PropertyIDRes['latitude'],
                    'latitude_source' => 'property_details_mls',
                    'longitude' => $PropertyIDRes['longitude'],
                    'longitude_source' => 'property_details_mls'
    
                ));
                $Parms = array('cron_function_name' => CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS, 'insights_property_id' => $PropertyIDRes['id'], 
                'cron_function_status_flag' => MlsNumberReceived, 'checked_in_usps' => 'Y', 'month' => date('m'), 'year' => date('Y') );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);      
                 
            }        
            else{
                self::UpdateInsightsMain($Property['insights_property_id'], array('checked_in_usps' => 'Y'));
                $Parms = array('cron_function_name' =>CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AddressNotFoundInUSPS, 'checked_in_usps' => 'Y',   'month' => date('m'), 'year' => date('Y'));  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                
            }
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_MAPPING_COMPLETED,'Y');  
        }
        
        $Properties = self::USPSAbbPropertiesToBeMappedWithInbestments();
        // echo 'USPSAbbPropertiesToBeMappedWithInbestments::<pre>';
        // print_r($Properties);          
        // Cron-Function-Complete-Status
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($Properties,CONFIG_IS_MAPPING_COMPLETED,'P');           
        foreach ($Properties as $Property) {
            $PropertyIDRes = self::FindInbestmentsPropertyID($Property['insights_property_id'], $Property['property_address'], $Property['property_city'], $Property['property_state'], 0, $Property['property_zipcode']);
            if (count($PropertyIDRes) && isset($PropertyIDRes['id']) && $PropertyIDRes['id'] > 0){
                self::UpdateInsightsMain($Property['insights_property_id'], array(
                    'inbestments_property_id' => $PropertyIDRes['id'], 
                    'checked_in_usps_abb' => 'Y', 
                    'bedroom' => $PropertyIDRes['bedroom_count'], 
                    'bedroom_src' => 'property_details_mls', 
                    'bathroom' => $PropertyIDRes['bathroom_count'],
                    'bathroom_src' => 'property_details_mls',  
                    'square_foot' => $PropertyIDRes['square_foot'],
                    'square_foot_src' => 'property_details_mls',  
                    'year_built' => $PropertyIDRes['year_built'],
                    'year_built_src' => 'property_details_mls',  
                    'purchase_price' => $PropertyIDRes['sold_price'],
                    'purchase_price_src' => 'property_details_mls',  
                    'purchase_date' => $PropertyIDRes['sold_date'],
                    'purchase_date_src' => 'property_details_mls', 
                    'latitude' => $PropertyIDRes['latitude'],
                    'latitude_source' => 'property_details_mls',
                    'longitude' => $PropertyIDRes['longitude'],
                    'longitude_source' => 'property_details_mls'
    
                ));
                $Parms = array('cron_function_name' => CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS, 'insights_property_id' => $PropertyIDRes['id'], 
                'cron_function_status_flag' => MlsNumberReceived,'checked_in_usps_abb' => 'Y', 'month' => date('m'), 'year' => date('Y') );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);   
                             
            }
             else {
                self::UpdateInsightsMain($Property['insights_property_id'], array('checked_in_usps_abb' => 'Y'));
                $Parms = array('cron_function_name' =>CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => AddressNotFoundInUSPSAbb, 'checked_in_usps_abb' => 'Y',   'month' => date('m'), 'year' => date('Y'));  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                
             }
             $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($Property['insights_property_id'], CONFIG_IS_MAPPING_COMPLETED,'Y');      

        }
        echo '----------StartUpdateCompleteStatus';
        
        $UpdateCompleteStatusForMapping = Common::UpdateCompleteStatusForMapping();     
             
        echo '----------EndUpdateCompleteStatus';
    }
    private static function USPSPropertiesToBeMappedWithInbestments()
    {
        $Obj = new SqlManager();
        $Query = "	SELECT im.insights_property_id insights_property_id, usps.address2abbreviation property_address, usps.city property_city, usps.state property_state, usps.zip5  property_zipcode
        FROM insights_main im LEFT JOIN insights_address_usps usps ON im.insights_property_id = usps.insights_property_id
        WHERE ( im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0 OR im.inbestments_property_id ='') AND im.checked_in_inbestments='Y' AND im.has_multi_match='N' 
        AND im.checked_in_usps='N'  AND ( usps.error IS NULL OR usps.error='')  
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.property_address NOT LIKE '123 Main Street' 
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS."'  AND  icf.cron_function_frequency='OneTime' )
        ORDER BY insights_property_id DESC
        LIMIT 5 ";      
        return $Obj->GetQuery($Query);

    }
    private static function USPSAbbPropertiesToBeMappedWithInbestments()
    {
        $Obj = new SqlManager();
        $Query = "	SELECT im.insights_property_id insights_property_id, usps.address2abbreviation property_address, usps.city property_city, usps.state property_state, usps.zip5  property_zipcode
        FROM insights_main im LEFT JOIN insights_address_usps usps ON im.insights_property_id = usps.insights_property_id
        WHERE ( im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0 OR im.inbestments_property_id ='') AND im.checked_in_inbestments='Y' AND im.has_multi_match='N' 
        AND im.checked_in_usps='Y' AND im.checked_in_usps_abb='N'  AND ( usps.error IS NULL OR usps.error='')   AND usps.address2abbreviation!='' 
        AND im.property_address NOT LIKE '123 Main Street' 
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE icfs.cron_function_name='".CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS."'  AND  icf.cron_function_frequency='OneTime' )
        ORDER BY insights_property_id DESC
        LIMIT 5 ";          
        return $Obj->GetQuery($Query);
    }

    
    public static function ParseZestimateData($Property, $CallAssessment = true)
    {
        echo "ParseZestimateData";
        print_r($Property);

        $Row = array();
        $currentYear = date('Y');
        $MlsSource = 'NWM';
        if(isset($Property['ml_number'])) {
            $FetchMlsSource = substr($Property['ml_number'], 0, 3);
            if($FetchMlsSource == 'MFR') {
                $MlsSource = 'MFR'; 
            }    
        }
        print_r($MlsSource);

        $ZData = self::GetZestimateAPIData($Property['property_address'], $Property['property_city'], $Property['property_state'], $Property['property_zipcode'], $Property['unit_number'], $MlsSource);
        echo '$ZDATA';
        print_r($ZData);
        if($CallAssessment && (empty($Property['property_tax_year']) || $Property['property_tax_year'] != $currentYear) && isset($ZData->bundle[0]->zpid)) {
            $AssessmentData = self::GetAssesmentData($ZData->bundle[0]->zpid, $MlsSource);
        }
            
        if (
            isset($ZData)
            && isset($ZData->bundle)
            && isset($ZData->bundle[0])
        ) {
            $Est = $ZData->bundle[0];
            if (isset($AssessmentData)
                && isset($AssessmentData->bundle)
                && isset($AssessmentData->bundle[0]) ) {
                    $Est = (object) array_merge((array) $Est, (array) $AssessmentData->bundle[0]);
            }        
            if (isset($Est->zpid))
                $Row['zpid'] = $Est->zpid;
            if (isset($Est->zillowUrl)) 
                $Row['zillow_url'] = $Est->zillowUrl;    

            if (isset($Est->streetName))
                $Row['street'] = $Est->streetName;
            if (isset($Est->postalCode))
                $Row['zipcode'] = $Est->postalCode;
            if (isset($Est->city))
                $Row['city'] = $Est->city;
            if (isset($Est->state))
                $Row['state'] = $Est->state;
            if (isset($Est->Latitude))
                $Row['latitude'] = $Est->Latitude;
            if (isset($Est->Longitude))
                $Row['longitude'] = $Est->Longitude;
            
            if (isset($Est->fips))
                $Row['fips_county'] = $Est->fips;
            
            if (isset($Est->taxYear))
                $Row['tax_assessment_year'] = $Est->taxYear;
            if (isset($Est->taxAmount))
                $Row['tax_assessment'] = $Est->taxAmount;
            if (isset($Est->building[0]->yearBuilt))
                $Row['year_built'] = $Est->building[0]->yearBuilt;
            if (isset($Est->lotSizeSquareFeet))
                $Row['lot_size'] = $Est->lotSizeSquareFeet;
            if (isset($Est->areas[0]->areaSquareFeet))
                $Row['living_square_foot'] = $Est->areas[0]->areaSquareFeet;
            if (isset($Est->building[0]->baths))
                $Row['bathrooms'] = $Est->building[0]->baths;
            if (isset($Est->building[0]->bedrooms))
                $Row['bedrooms'] = $Est->building[0]->bedrooms;
            if (isset($Est->lastSoldDate)) {
                $Row['sold_last_on'] = self::convertZDate($Est->lastSoldDate);
            }
            if (isset($Est->zestimate)) {
                if (($Est->zestimate) >= 10500)
                    $Row['est_price'] = $Est->zestimate + rand(-10000, 10000);
                else
                    $Row['est_price'] = $Est->zestimate;

                $Row['external_est_price'] = $Est->zestimate;    

                if (isset($Est->lowPercent )) {
                    $lowEstPrice = $Est->zestimate - ($Est->zestimate * ($Est->lowPercent / 100));
                    if ($lowEstPrice >= 10500)
                        $Row['low_est_price'] = $lowEstPrice + rand(-10000, 10000);
                    else
                        $Row['low_est_price'] = $lowEstPrice;

                    $Row['external_low_est_price'] = $lowEstPrice;
                }        
                if (isset($Est->highPercent)) {
                    $highEstPrice = $Est->zestimate + ($Est->zestimate * ($Est->highPercent / 100));
                    if ($highEstPrice >= 10500)
                        $Row['high_est_price'] = $highEstPrice + rand(-10000, 10000);
                    else
                        $Row['high_est_price'] = $highEstPrice;

                    $Row['external_high_est_price'] = $highEstPrice;    
                }        
            }
            
            if (isset($Est->rentalZestimate)) {
                if ($Est->rentalZestimate >= 350)
                    $Row['est_monthly_rent'] = $Est->rentalZestimate + rand(-300, 300);
                else    
                    $Row['est_monthly_rent'] = $Est->rentalZestimate;

                $Row['external_est_monthly_rent'] = $Est->rentalZestimate; 

                if (isset($Est->rentalLowPercent)) {
                    $lowEstRent = $Est->rentalZestimate - ($Est->rentalZestimate * ($Est->rentalLowPercent / 100));
                    if ($lowEstRent >= 350)
                        $Row['low_est_monthly_rent'] = $lowEstRent + rand(-300, 300);
                    else
                        $Row['low_est_monthly_rent'] = $lowEstRent;

                    $Row['external_low_est_monthly_rent'] = $lowEstRent;    
                    }
                if (isset($Est->rentalHighPercent)) {
                    $highEstRent = $Est->rentalZestimate + ($Est->rentalZestimate * ($Est->rentalHighPercent / 100));
                    if ($highEstRent >= 350)
                        $Row['high_est_monthly_rent'] = $highEstRent + rand(-300, 300);
                    else
                        $Row['high_est_monthly_rent'] = $highEstRent;
                    $Row['external_high_est_monthly_rent'] = $highEstRent;    
                }
            }
        } else {
            // print_r($ZData);
            $Row = $ZData;
            // $Row = 3;
        }

        return $Row;
    }
    public static function GetAssesmentData($zpid, $MlsSource)
    {

        if (self::CheckZestimateAPIID(false, PUB_ASSESSMENT_EXTERNAL_API, $MlsSource) === false)
            return (object)['total' => 0];
        $avmId = self::CheckZestimateAPIID(true, PUB_ASSESSMENT_EXTERNAL_API, $MlsSource);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.bridgedataoutput.com/api/v2/pub/assessments?access_token='.$avmId.'&limit=1&sortBy=year&order=desc&zpid='.$zpid);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $assessmentResponse = curl_exec($ch);
        curl_close($ch);

        $assessmentData = json_decode($assessmentResponse);
        return $assessmentData;
    }
    public static function GetZestimateAPIData($Address, $City, $State, $ZipCode, $UnitNumber, $MlsSource)
    {
        $Address = trim($Address);
        if (isset($UnitNumber) && trim($UnitNumber) != '') {
            $UnitNumber = trim($UnitNumber);
            $Address = $Address .' '. $UnitNumber .' '. $City .' '. $State .' '. $ZipCode;
        }
        else {
            $Address = $Address .' '. $City .' '. $State .' '. $ZipCode;
        }
        echo 'GETZESTIMATEAPIDATA';
    if (self::CheckZestimateAPIID(false, ZESTIMATE_V2_EXTERNAL_API, $MlsSource) === false){
            echo 'Return Object';
            return (object)['total' => 0];   
    }
        $avmId = self::CheckZestimateAPIID(true, ZESTIMATE_V2_EXTERNAL_API, $MlsSource);
        $ch = curl_init();
        echo '$avmId';
        print_r($avmId);
        curl_setopt($ch, CURLOPT_URL, 'https://api.bridgedataoutput.com/api/v2/zestimates_v2/zestimates?access_token='.$avmId.'&address='. urlencode($Address));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $zestimateResponse = curl_exec($ch);
        curl_close($ch);
    
        $zestimateData = json_decode($zestimateResponse);
        $bundleArray = $zestimateData->bundle;
        if (empty($bundleArray)) {
            if (self::CheckZestimateAPIID(false, ZESTIMATE_V2_EXTERNAL_API, $MlsSource) === false)
                return (object)['total' => 0];
            $avmId = self::CheckZestimateAPIID(true, ZESTIMATE_V2_EXTERNAL_API, $MlsSource);
            $zestimateUrl = 'https://api.bridgedataoutput.com/api/v2/zestimates_v2/zestimates?access_token='.$avmId;
            $streetaddress = explode(' ', $Address);
            $StreetName = '';
            $HouseNumber = '';
            if (isset($streetaddress[0])) {
                if (is_numeric($streetaddress[0]))
                    $HouseNumber = $streetaddress[0];
                else if (is_string($streetaddress[0]))
                    $StreetName = $streetaddress[0]; 
            }
            // if($StreetName) 
            //     $zestimateUrl = $zestimateUrl.'&streetName='. urlencode($StreetName);
            if($HouseNumber)    
                $zestimateUrl = $zestimateUrl.'&houseNumber='. urlencode($HouseNumber);
            else 
                return (object)['total' => 0];        
            if($City)   
                $zestimateUrl = $zestimateUrl.'&city='. urlencode($City);
            if($State) 
                $zestimateUrl = $zestimateUrl.'&state='. urlencode($State);  
            if($ZipCode) 
                $zestimateUrl = $zestimateUrl.'&postalCode='. urlencode($ZipCode); 
            // if (isset($UnitNumber) && trim($UnitNumber) != '') 
            //     $zestimateUrl = $zestimateUrl.'&unitNumber='. trim($UnitNumber);  
            echo  'url'.$zestimateUrl;             
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $zestimateUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $splitAddressRes = curl_exec($ch);
            curl_close($ch);
            $zestimateData = json_decode($splitAddressRes);

            if ($zestimateData->total > 1) {
                if ($HouseNumber && isset($streetaddress[1])) {
                    $StreetName = $streetaddress[1];
                }
                $matchedBundle = array();
                $valid = false;
                foreach($zestimateData->bundle as $item) {

                   if ($StreetName) {
                        $valid = isset($item->streetName) && $item->streetName ? 
                        stripos($item->streetName, $StreetName) !== false : false;
                        if ($valid === false) {
                            $valid = isset($item->streetSuffix) && $item->streetSuffix ? 
                            stripos($item->streetSuffix, $StreetName) !== false : false;
                            if ($valid === false) {
                                $valid = isset($item->directionPrefix) && $item->directionPrefix ? 
                                stripos($item->directionPrefix, $StreetName) !== false : false;
                                if ($valid === false) {
                                    $valid = isset($item->directionSuffix) && $item->directionSuffix ? 
                                    stripos($item->directionSuffix, $StreetName) !== false : false;
                                }
                            }
                        }
                   }

                   if (isset($UnitNumber) && $UnitNumber) {
                        $valid = isset($item->unitNumber) && $item->unitNumber ? 
                        stripos($item->unitNumber, $UnitNumber) !== false : false;
                        if ($valid === false) {
                            $valid = isset($item->unitPrefix) && $item->unitPrefix ? 
                            stripos($item->unitPrefix, $UnitNumber) !== false : false;
                            if ($valid === false) {
                                $valid = isset($item->streetName) && $item->streetName ? 
                                stripos($item->streetName, $StreetName) !== false : false;
                                if ($valid === false) {
                                    $valid = isset($item->streetSuffix) && $item->streetSuffix ? 
                                    stripos($item->streetSuffix, $StreetName) !== false : false;
                                    if ($valid === false) {
                                        $valid = isset($item->directionPrefix) && $item->directionPrefix ? 
                                        stripos($item->directionPrefix, $StreetName) !== false : false;
                                        if ($valid === false) {
                                            $valid = isset($item->directionSuffix) && $item->directionSuffix ? 
                                            stripos($item->directionSuffix, $StreetName) !== false : false;
                                        }
                                    }
                                }
                            }
                        }
                    }
                
                    if ($valid === true) {
                        array_push($matchedBundle, $item);
                        $zestimateData->bundle = $matchedBundle;
                        break;
                    }
                }
            }
        }

        return $zestimateData;
    }
    public static function CheckZestimateAPIID($zAPIKey, $key, $MlsSource)
    {
        var_dump(false);
        print_r($zAPIKey);
        var_dump(false);
        print_r($MlsSource);
        var_dump(false);
        print_r($key);
        $zAPICallUtilization = self::GetZAPIKeyDetails($key, $MlsSource);
        print_r($zAPICallUtilization);
        if($zAPIKey) {
            $zAPICallUtilization['daily_total_used'] = $zAPICallUtilization['daily_total_used'] + 1;
            $zAPICallUtilization['daily_remaining'] = $zAPICallUtilization['daily_remaining'] - 1;
            self::UpdateExternalAPICustLog($key, $zAPICallUtilization, $MlsSource);
            return $zAPICallUtilization['token'];
        }
        if($zAPICallUtilization['daily_total_used'] == $zAPICallUtilization['daily_total_allows'])
            return false;
        else 
            return true;    
    }
    private static function GetZAPIKeyDetails($key, $MlsSource)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('external_api_cust_log'));
        $Obj->AddFlds(array('id', 'api_key', 'token', 'daily_total_allows','daily_total_used', 'daily_remaining' ));
        $Obj->AddFldCond('api_key', $key);
        $Obj->AddFldCond('mls_source', $MlsSource);
        return $Obj->GetSingle();
    }
    private static function UpdateExternalAPICustLog($key, $Data, $MlsSource)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('external_api_cust_log'));
        $Obj->AddInsrtFlds($Data);
        $Obj->AddFldCond('api_key', $key);
        $Obj->AddFldCond('mls_source', $MlsSource);
        $Obj->Update();
    }

    public static function convertZDate($DT)
    {
        $DTArr = explode('/', $DT);
        if (count($DTArr) == 3) {
            return $DTArr[2] . '-' . $DTArr[1] . '-' . $DTArr[0];
        }
        return '';
    }

    public static function GetPreviousMonthData($InsightsPropertyID, $CurrentMonth, $CurrentYear)
    {
        $Date = strtotime($CurrentYear . '-' . $CurrentMonth . '-01');
        $Month = date('m', strtotime('-1 month', $Date));
        $Year = date('Y', strtotime('-1 month', $Date));

        $Obj = new SqlManager();
        $Obj->AddTbls('insights_est_price_new_index');
        $Obj->AddFlds(array('est_price', 'pcomp_criteria_id'));
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);
        $Obj->AddFldCond('is_best', 'Y');
        return $Obj->GetSingle();
    }

}
?>