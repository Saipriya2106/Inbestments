<?php
  ini_set('memory_limit', '-1');
  ini_set('max_execution_time', '0');
  ini_set('mysql.connect_timeout', 300);
  ini_set('default_socket_timeout', 300); 
  include 'config.php';
  require_once 'class.Common.php';
  require_once 'class.HomeValueCustom.php';
  require_once 'class.InsightExternalProperties.php';
  require_once 'class.EstimatedPrice.php';
  require_once 'sqlManager.php';

  ob_start();
  $Parms = array('cron_function_name' =>$_SERVER['SCRIPT_NAME']." :: ".IS_SERVER_VARIABLE, 'insights_property_id' => 0, 
  'cron_function_status_flag' => date("d-M-Y ==>  h:i:s "), 'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
  
   $externalapi = Common::callExternalAPI("https://betteruptime.com/api/v1/heartbeat/Df47yUrppf1qu8jtncmYUMAL", 'POST', "");
  // echo '$externalapi'; 
   //print_r($externalapi);
    echo "<pre> ";
    echo "Started At: ".date(DB_DATETIME_FORMAT)."\n";
    define('AUTOMATION_CONDITION', ' '); 

    define('AUTOMATION_CONDITION_WITH_ALIAS', ' ');
    $homevalue = new HomeValueCustom();


    // Get cron functions current information and check active status
    $CronFunctionFrequency=Common::GetCronFunctionFrequency(); 
    echo '$CronFunctionFrequency';
    print_r( $CronFunctionFrequency);
    $InbSubjectProperties=Common::CheckCronFunctionStatus($CronFunctionFrequency,CONFIG_GET_INB_SUBJECT_PROPERTIES_CUSTOM);
    echo '$InbSubjectProperties';
    print_r( $InbSubjectProperties);
    $ExternalPropertyDataArray = array();
    $listPriceCondition = false;
    try {
      echo "\n Price Estimate Started At: ".date(DB_DATETIME_FORMAT)."\n";
      $CallGetInbSubjectProperty= $homevalue->CallGetInbSubjectProperty($InbSubjectProperties,'Regular');
      echo '$CallGetInbSubjectProperty';
      print_r( $CallGetInbSubjectProperty);
      $zillowEventTriggerTime = new DateTime('12:00:00');
      // Calculate 30 minutes before the target time
      print_r('Hii');
      $thirtyMinutesBeforeTriggerTime = clone $zillowEventTriggerTime;
      $thirtyMinutesBeforeTriggerTime->sub(new DateInterval('PT30M')); 

      foreach ($CallGetInbSubjectProperty as $Property) {
        $currentDateTimeObj = new DateTime(CURRENT_DATETIME);
        print_r('Hello');
        // Check if the current time is within 30 minutes before zillow trigger time
        
        if ($currentDateTimeObj >= $thirtyMinutesBeforeTriggerTime && $currentDateTimeObj <= $zillowEventTriggerTime) {
          $listPriceCondition = $Property['list_price'] >= LOW_LISTPRICE;
        } else {
          $listPriceCondition = $Property['list_price'] >= LOW_LISTPRICE && $Property['list_price'] <= HIGH_LISTPRICE;
        }
        echo '$listPriceCondition';
        print_r($listPriceCondition);
        if ($listPriceCondition) {

          $GetCronFunctionStatus = HomeValueCustom::GetCronFunctionStatus($Property['insights_property_id']);
          echo '$Propertyinsights_property_id and $GetCronFunctionStatus';
          print_r($Property['insights_property_id']);
          print_r($GetCronFunctionStatus);

          if(empty($GetCronFunctionStatus)) {
            $ExternalPropertyData = array();
            
            $ExternalPropertyData = EstimatedPrice::ParseZestimateData($Property);
            if(is_array($ExternalPropertyData)) {
              $ExternalPropertyData['est_month'] = CURRENT_MONTH;
              $ExternalPropertyData['est_year'] = CURRENT_YEAR;
              $ExternalPropertyData['insights_property_id'] = $Property['insights_property_id'];
              } else {
                $ExternalPropertyData -> insights_property_id = $Property['insights_property_id'];
              }
              $ExternalPropertyDataArray[] = $ExternalPropertyData;
            $UpdateExternalHome = HomeValueCustom::UpdateExternalHomeValue($ExternalPropertyData, $Property);
          }  
        }
      }

      /*
      $CallUpdatePricePropertiesAsBest= HomeValueCustom::UpdatePricePropertiesAsBest(CURRENT_MONTH, CURRENT_YEAR);
      $CallUpdateAdjustmentPrice = HomeValueCustom::UpdateAdjustmentPrice(CURRENT_MONTH, CURRENT_YEAR);
      $CallHomeValueExternalCompare = $homevalue->HomeValueExternalCompare();
      */
    } catch (Exception $e) {
        echo 'Caught exception in price estimate: ',  $e->getMessage(), "\n";
    } finally {
        /*
        echo "\n Price Estimate Finished At: ".date(DB_DATETIME_FORMAT)."\n";
        try {
            echo "\n Rent Estimate Started At: ".date(DB_DATETIME_FORMAT)."\n";
             // Rent Eastimate
            $CallGetInbSubjectPropertyRent= $homevalue->CallGetInbSubjectPropertyRent(true,'Regular');  
        } catch (Exception $e) {
            echo 'Caught exception in rent estimate: ',  $e->getMessage(), "\n";
        } finally {
              echo "\n Rent Estimate Finished At: ".date(DB_DATETIME_FORMAT)."\n";
              try {
                echo "\n Rental External API Started At: ".date(DB_DATETIME_FORMAT)."\n";
                $CallFetchPropertiesForRental= InsightExternalProperties::CallFetchPropertiesForRental($ExternalPropertyDataArray);
                } catch (Exception $e) {
                echo 'Caught exception in rental external api:',  $e->getMessage(), "\n";
                } finally {
                echo "\n Rental External API Finished At: ".date(DB_DATETIME_FORMAT)."\n";
                try {
                  echo "\n AVM Update Started At: ".date(DB_DATETIME_FORMAT)."\n";
                  $InbSubjectPropertiesToUpdateAVM= $homevalue->GetInbSubjectPropertyForAVMtableForCustomHVandRent(CURRENT_MONTH, CURRENT_YEAR);
                  $UpdateAVMtableForCustomHVandRent = $homevalue->UpdateAVMtableForCustomHVandRent($InbSubjectPropertiesToUpdateAVM);
      
                } catch (Exception $e) {
                    echo 'Caught exception in avm update: ',  $e->getMessage(), "\n";
                } finally {
                    echo "\n AVM Update Finished At: ".date(DB_DATETIME_FORMAT)."\n";
                    
                    try {
                      echo "\n Price-Rent Is_Best Update Started At: ".date(DB_DATETIME_FORMAT)."\n";
      
                      $InbSubjectPropertiesToUpdatePriceRentIsBest= $homevalue->GetInbSubjectPropertyForCustomHV();
                      $UpdatePriceRentIsBestTableForCustomHVandRent = $homevalue->UpdatePriceRentIsBestTableForCustomHVandRent($InbSubjectPropertiesToUpdatePriceRentIsBest);
                      // Adjust Median Price
                      $CallUpdateIsBestMedianPrice = $homevalue->UpdateIsBestMedianPrice();
                    } catch (Exception $e) {
                        echo 'Caught exception in price-rent is_best: ',  $e->getMessage(), "\n";
                    } finally {
                      echo "\n Price-Rent Is_Best Update Finished At: ".date(DB_DATETIME_FORMAT)."\n";
                    }
                }
            }
        
        
        } 
            */  
    }
 
  


    echo "\n Finished At: ".date(DB_DATETIME_FORMAT)."\n";
    echo "######################### Cron Job Execution ENDED #########################";

		
	//ob_start('ob_file_callback');
    /*
	$file =  dirname(__FILE__) . '/logs/cron-log/' . date("Y-m-d_h-i-s").'-home-value-custom-task-log.txt';
	file_put_contents( $file, ob_get_contents(), FILE_APPEND | LOCK_EX);
	ob_end_flush();
    */
	
?>