<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
    $requestFromSmartCMA = $_REQUEST['request_from_lead_gen'] ?? false;
    //echo '$_REQUEST';
    //print_r($requestFromSmartCMA);
	ob_start();
   // echo 'HII';
    ///echo '\n';
    
    if($requestFromSmartCMA ?? false){
        
        $insights_property_id = $_REQUEST['insights_property_id'] ?? false;
        $domain_name = $_REQUEST['domain_name'] ?? false;

        $_SESSION["domain_name"]=$domain_name; 

        $insightsData = array();
        $insightData = array();
        $insightData['insights_property_id'] = $insights_property_id;
        $insightsData[] = $insightData;
            
        ini_set('memory_limit', '-1');
        include 'config.php';
        require_once 'class.Common.php';
        require_once 'SqlManager.php';
        require_once 'class.SIMonthlyEmailsForContacts.php';
        require_once 'class.EstimatedPrice.php';
        require_once 'class.EmailMarketing.php';
        require_once 'class.EmailTemplate.php';
        require_once 'class.EmailQueue.php';
        require_once 'class.SIFlagIssues.php';
        require_once 'class.AtomAPI.php';
        require_once 'class.InsightExternalProperties.php';
        require_once 'class.HomeValue.php';
        require_once 'class.InsightsReportVariance.php';
        
        echo '$domain_name';
        print_r($domain_name);
        echo '\n';
        $DomainDetails=Common::GetDomainDetails($domain_name); 

        $JsonDecodeData =json_decode($DomainDetails['domain_data']); 
        echo '$JsonDecodeData\n';
        print_r($JsonDecodeData);
        echo '\n';
        if(!empty($DomainDetails)){
            $_SESSION["DOMAIN_NAME"]=$JsonDecodeData->name; 
            $_SESSION["DOMAIN_URL"]=$JsonDecodeData->website; 
            $_SESSION["DOMAIN_LOGO"]=$JsonDecodeData->logo; 
            $_SESSION["DOMAIN_SOCIAL_FACEBOOK"]=$JsonDecodeData->social->fb; 
            $_SESSION["DOMAIN_SOCIAL_TWITTER"]=$JsonDecodeData->social->twitter; 
            $_SESSION["DOMAIN_SOCIAL_LINKEDIN"]=$JsonDecodeData->social->linkedin; 
        } 
        
        echo "Session details";
        print_r($_SESSION["DOMAIN_NAME"]);
        print_r($_SESSION["DOMAIN_URL"]);
        print_r($_SESSION["DOMAIN_LOGO"]);
        print_r($_SESSION["DOMAIN_SOCIAL_FACEBOOK"]);
        print_r($_SESSION["DOMAIN_SOCIAL_TWITTER"]);
        print_r($_SESSION["DOMAIN_SOCIAL_LINKEDIN"]);
        
        
        $FunctionActive= true;
        $ExternalAPIFunctionActive= true;
        
        $CronFunctionFrequency=Common::GetCronFunctionFrequency(); 
      
       print_r($CronFunctionFrequency);
        
        define('AUTOMATION_CONDITION', '  AND  insights_property_id IN ( '.$insights_property_id.')  '); 
        define('AUTOMATION_CONDITION_WITH_ALIAS', '  AND  im.insights_property_id IN ( '.$insights_property_id.')  ');
        
        $GetPropertiesForExternalActive=Common::CheckCronFunctionStatus($CronFunctionFrequency,CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API);

        print_r($GetPropertiesForExternalActive);
       
        
        $WelcomeEmail_datetime1 = date_create(date(DB_DATETIME_FORMAT));
        
        
        $CallSendWelcomeEmail = SIMonthlyEmailsForContacts::SendWelcomeEmails(CURRENT_MONTH, CURRENT_YEAR);
        
       
        $WelcomeEmail_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $interval       = date_diff($WelcomeEmail_datetime1, $WelcomeEmail_datetime2); 
        $diff           = $interval->format('%R %a days %i Minute %s Seconds');
       
      
        print_r($diff);
            
        

        $Mapping_datetime1 = date_create(date(DB_DATETIME_FORMAT));
        

        EstimatedPrice::GetMappedPropertiesWithInbestments();
        
        EstimatedPrice::CallFetchPropertiesToValidateUSPSAPI($FunctionActive);


        EstimatedPrice::CallFetchMissingMortgagePropsToValidateWithUSPSAPI($FunctionActive);

        
        EstimatedPrice::MappedUSPSPropertiesWithInbestments();
       
        
        $Mapping_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $Mapping_interval       = date_diff($Mapping_datetime1, $Mapping_datetime2); 
        $Mapping_diff           = $Mapping_interval->format('%R %a days %i Minute %s Seconds');

        echo 'Sending monthly emails';
        
        $CallSendMonthlyEmail =  SIMonthlyEmailsForContacts::SendMonthlyEmails(CURRENT_MONTH, CURRENT_YEAR);
        
 
  

        $CheckHomeValueCompleted = Common::CheckIsBestStatus($insights_property_id);

        print_r($CheckHomeValueCompleted);

        

        echo "<hr>##3: ".date('h:i:s') . "<br>";
        sleep(5);
        echo  "<hr>##2: ".date('h:i:s') . "<br>";
        $MonthlyEmail_datetime1 = date_create(date(DB_DATETIME_FORMAT));


         $CallSendMonthlyEmail =  SIMonthlyEmailsForContacts::SendMonthlyEmails(CURRENT_MONTH, CURRENT_YEAR);
        

        $MonthlyEmail_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $MonthlyEmail_interval       = date_diff($MonthlyEmail_datetime1, $MonthlyEmail_datetime2); 
        $MonthlyEmail_diff           = $MonthlyEmail_interval->format('%R %a days %i Minute %s Seconds');


        $Attom_datetime1 = date_create(date(DB_DATETIME_FORMAT));

        
        $CurrentATOMApiKey = AtomAPI::GetCurrentATOMApiKey();

        echo '$Atomdetails';
        print_r($Attom_datetime1);
        
        
        $AVMProperties = AtomAPI::GetPropertiesToBeFetchedForAVM();
 
       
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($AVMProperties,CONFIG_IS_ATTOM_API_COMPLETED,'P');
        

        $AtomProperties = AtomAPI::GetPropertiesToBeFetchedForPDAndSH();
        
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($AtomProperties,CONFIG_IS_ATTOM_API_COMPLETED,'P');

        
        $Assessment = AtomAPI::GetPropertiesToBeFetchedForAssessment();

        
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($Assessment,CONFIG_IS_ATTOM_API_COMPLETED,'P');

      
        $MortgageFromUSPS = AtomAPI::GetUSPSAddressToBeFetchedForPDAndSH();

    

        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($MortgageFromUSPS,CONFIG_IS_ATTOM_API_COMPLETED,'P');


       $MortgageFromUSPSAbb = AtomAPI::GetAbbUSPSAddressToBeFetchedForPDAndSH();
        
        $UpdateCronProcessStatus = Common::UpdateCronProcessStatus($MortgageFromUSPSAbb,CONFIG_IS_ATTOM_API_COMPLETED,'P');
        AtomAPI::FetchDataFromATOM($AVMProperties, $AtomProperties, $Assessment, $MortgageFromUSPS, $MortgageFromUSPSAbb);
        

        $Attom_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $Attom_interval       = date_diff($Attom_datetime1, $Attom_datetime2); 
        $Attom_diff           = $Attom_interval->format('%R %a days %i Minute %s Seconds');


        $CallSendMonthlyEmail =  SIMonthlyEmailsForContacts::SendMonthlyEmails(CURRENT_MONTH, CURRENT_YEAR);


        $External_datetime1 = date_create(date(DB_DATETIME_FORMAT));
        

        if($GetPropertiesForExternalActive){


            $CallFetchPropertiesForCalibration= InsightExternalProperties::CallFetchPropertiesForCalibration($GetPropertiesForExternalActive);

           $External_datetime1 = date_create(date(DB_DATETIME_FORMAT));
            $External_datetime2      = date_create(date(DB_DATETIME_FORMAT));
            $External_interval       = date_diff($External_datetime1, $External_datetime2); 
            $External_diff           = $External_interval->format('%R %a days %i Minute %s Seconds');
        }else{
            $UpdateCronCompleteStatus = Common::UpdateCronCompleteStatus($insights_property_id, CONFIG_IS_EXTERNAL_API_COMPLETED,'Y');
        }
        
        $CallSendMonthlyEmail =  SIMonthlyEmailsForContacts::SendMonthlyEmails(CURRENT_MONTH, CURRENT_YEAR);
     
        
        $HomeValue_datetime1 = date_create(date(DB_DATETIME_FORMAT));


        $homevalue = new HomeValue();
        
        
        $CallGetInbSubjectProperty= $homevalue->CallGetInbSubjectProperty($FunctionActive);

        print_r($CallGetInbSubjectProperty);
        
        $CallGetNonInbSubjectProperty= $homevalue->CallGetNonInbSubjectProperty($FunctionActive);

        print_r($CallGetNonInbSubjectProperty);

        $CallGetExternalSubjectProperty= $homevalue->CallGetExternalSubjectProperty($FunctionActive);

        print_r($CallGetExternalSubjectProperty);

        $CallUpdatePricePropertiesAsBest= HomeValue::UpdatePricePropertiesAsBest(CURRENT_MONTH, CURRENT_YEAR);

        print_r($CallUpdatePricePropertiesAsBest);

        $CallUpdateAdjustmentPrice = HomeValue::UpdateAdjustmentPrice(CURRENT_MONTH, CURRENT_YEAR);

        $CallHomeValueExternalCompare = $homevalue->HomeValueExternalCompare();


        $HomeValue_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $HomeValue_interval       = date_diff($HomeValue_datetime1, $HomeValue_datetime2); 
        $HomeValue_diff           = $HomeValue_interval->format('%R %a days %i Minute %s Seconds');
   
        // =============================Rent Estimate===================================================

        $RentEstimate_datetime1 = date_create(date(DB_DATETIME_FORMAT));

        
    
        $CallGetInbSubjectPropertyRent= $homevalue->CallGetInbSubjectPropertyRent($FunctionActive);
  
       $CallGetNonInbSubjectPropertyRent= $homevalue->CallGetNonInbSubjectPropertyRent($FunctionActive);

        $CallGetExternalSubjectPropertyRent= $homevalue->CallGetExternalSubjectPropertyRent($FunctionActive);

        


        $RentEstimate_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $RentEstimate_interval       = date_diff($RentEstimate_datetime1, $RentEstimate_datetime2); 
        $RentEstimate_diff           = $RentEstimate_interval->format('%R %a days %i Minute %s Seconds');
    

        $UpdateSendMailStatus = Common::UpdateSendMailStatus($insights_property_id, SEND_MONTHLY_REPORT, 'Y');
        $CallSendMonthlyEmail =  SIMonthlyEmailsForContacts::SendMonthlyEmails(CURRENT_MONTH, CURRENT_YEAR);


        $InsightIssues_datetime1 = date_create(date(DB_DATETIME_FORMAT));
      
        
        $CallFlagIssues= SIFlagIssues::CallFlagIssues($FunctionActive);   

      //  print_r($CallFlagIssues);

        $InsightIssues_datetime2      = date_create(date(DB_DATETIME_FORMAT));
        $InsightIssues_interval       = date_diff($InsightIssues_datetime1, $InsightIssues_datetime2); 
        $InsightIssues_diff           = $InsightIssues_interval->format('%R %a days %i Minute %s Seconds');
       


        if($GetPropertiesForExternalActive){
            $Variance_datetime1 = date_create(date(DB_DATETIME_FORMAT));
            $insightvariance = new InsightsReportVariance();
            $CallHomeValueVariance= $insightvariance->CallHomeValueVariance($FunctionActive);

            $Variance_datetime2      = date_create(date(DB_DATETIME_FORMAT));
            $Variance_interval       = date_diff($Variance_datetime1, $Variance_datetime2); 
            $Variance_diff           = $Variance_interval->format('%R %a days %i Minute %s Seconds');
          
               
        }
     
        
    }
    
?>