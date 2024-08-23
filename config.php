<?php
	define('IS_SERVER', 'R');
	if (IS_SERVER === 'R')
		define('APP_URL', 'https://dev.inbestments.com/');
	else
		// define('APP_URL', 'https://inbestments.com/');
		define('APP_URL', 'https://inbestments.com/');
	


	define('CURRENT_MONTH', date('m'));
	define('CURRENT_YEAR', date('Y'));

	$CurrentDate  = date('Y-m-d');
	$PreviouseMonth = date ('m', strtotime ( '-1 month' , strtotime ( $CurrentDate )));
	$PreviouseYear = date ('Y', strtotime ( '-1 month' , strtotime ( $CurrentDate )));
	// Current Date Time
	define('CURRENT_DATETIME', date('Y-m-d h:i:s'));
	
	// Send mail types
	define('CONFIG_IS_WELCOME_EMAIL_SENT', 'IS_WELCOME_EMAIL_SENT');
	define('DB_DATETIME_FORMAT', 'Y-m-d H:i:s');
	define('DB_HOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','root123');
    define('DB_NAME','Inbestments');
	define('QUERY_LOG', false);
	//define('TABLE_PREFIX', 'tbl_');
	//define('HOST_NAME', 	'vinjoy-dev.cfx4ezccplss.us-west-2.rds.amazonaws.com');
		define('USER_NAME', 	'root');
		define('PASSWORD', 		'root123');
		define('DATABASE_NAME',	'Inbestments');

	define('CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API', 'EXTERNAL_API:GET_PROPERTIES_FOR_EXTERNAL_API');
	// --------------------------------------------------------------------------------------------------------------------------------------//
	define('CONFIG_PROPERTY_CONDITION_WITH_ALIAS', ' '); 
	// Rent-Restimate ::  tbl_insights_cron_function_frequency.cron_function_name
	define('CONFIG_PROPERTY_CONDITION', '  '); 
	define('CONFIG_MAPPED_PROPERTIES_WITH_INBESTMENTS', 'PROPERTY_MAPPING:MAPPED_PROPERTIES_WITH_INBESTMENTS');
	define('CONFIG_IS_MAPPING_COMPLETED', 'IS_MAPPING_COMPLETED');
	define('MlsNumberReceived','MLS_NUMBER_RECEIVED');
	define('AddressNotFoundInMLS','ADDRESS_NOT_FOUND_IN_MLS');
	define('AddressNotFoundAfterValidateUSPS','ADDRESS_NOT_FOUND_AFTER_VALIDATE_USPS');
	define('CONFIG_FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API', 'PROPERTY_MAPPING:FETCH_PROPERTIES_TO_VALIDATE_WITH_USPS_API');
	define('CONFIG_FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API', 'PROPERTY_MAPPING:FETCH_MISSING_MORTGAGE_PROPS_TO_VALIDATE_WITH_USPS_API');
	define('OTHER_THAN_PROPERTIES_CLOUD_PATH', 'https://d20guwoufnj86i.cloudfront.net/');
	define('USER_IMAGE_PATH', 'images/user/');
	define('DOT_LOGO','https://dfex9umbat57h.cloudfront.net/inbestments-new/images/Inb-images/dots.png');
	define('FACEBOOK_LOGO','https://dfex9umbat57h.cloudfront.net/inbestments-new/images/Inb-images/ico-facebook.png');
	define('TWITTER_LOGO','https://dfex9umbat57h.cloudfront.net/inbestments-new/images/Inb-images/ico-twitter.png');
	define('LINKEDIN_LOGO','https://dfex9umbat57h.cloudfront.net/inbestments-new/images/Inb-images/ico-linkedin.png');
	define('CONFIG_MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS', 'PROPERTY_MAPPING:MAPPED_USPS_PROPERTIES_WITH_INBESTMENTS');
	define('AddressNotFoundInUSPS','ADDRESS_NOT_FOUND_IN_USPS');
	define('AddressNotFoundInUSPSAbb','ADDRESS_NOT_FOUND_IN_USPSABB');
	define('CONFIG_IS_MONTHLY_EMAIL_SENT', 'IS_MONTHLY_EMAIL_SENT');
	define('SEND_MONTHLY_REPORT', 'send_monthly_report');
	define('CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM', 'ATTOM_API:GET_PROPERTIES_TO_BE_FETCHED_FOR_AVM');
	define('DB_DATE_FORMAT', 'Y-m-d');
	define('CONFIG_IS_ATTOM_API_COMPLETED', 'IS_ATTOM_API_COMPLETED');
	define('CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_PD_AND_SH', 'ATTOM_API:GET_PROPERTIES_TO_BE_FETCHED_FOR_PD_AND_SH');
	define('CONFIG_GET_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH', 'ATTOM_API:GET_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH');
	define('CONFIG_IS_EXTERNAL_API_COMPLETED', 'IS_EXTERNAL_API_COMPLETED');
	define('ZESTIMATE_V2_EXTERNAL_API', 'zestimate_v2_external_api');
	define('CONFIG_IS_HOME_VALUE_COMPLETED', 'IS_HOME_VALUE_COMPLETED');
	define('CONFIG_GET_INB_SUBJECT_PROPERTIES', 'HOME_VALUE:GET_INB_SUBJECT_PROPERTIES');
	define('PreviousMonthDataAvailable','PREVIOUS_MONTH_DATA_AVAILABLE');
	define('CompSetAvailable','COMPSET_AVAILABLE');
	define('CriteriaResultsAdded','CRITERIA_RESULT_ADDED');
	define('CompSetNotAvailable','COMPSET_NOT_AVAILABLE');
	define('CalculatedValuesAdded','CALCULATED_VALUES_ADDED');
	define('PreviousMonthDataNotAvailable','PREVIOUS_MONTH_DATA_NOT_AVAILABLE');
	define('CONFIG_GET_NON_INB_SUBJECT_PROPERTIES', 'HOME_VALUE:GET_NON_INB_SUBJECT_PROPERTIES');
	define('CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES', 'HOME_VALUE:GET_EXTERNAL_SUBJECT_PROPERTIES');
	define('CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST', 'HOME_VALUE:UPDATE_PRICE_PROPERTIES_AS_BEST');
	define('UpdateHomeValueIsBestNotHavingMlsNO','UPDATE_HOME_VALUE_IS_BEST_NOT_HAVING_MLS_NO');
	define('UpdateHomeValueIsBestHavingMlsNO','UPDATE_HOME_VALUE_IS_BEST_HAVING_MLS_NO');
	define('CONFIG_UPDATE_ADJUSTMENT_PRICE', 'HOME_VALUE:UPDATE_ADJUSTMENT_PRICE');
	define('UpdateAdjustmentPrice','UPDATE_ADJUSTMENT_PRICE');
	define('CONFIG_IS_HOME_VALUE_COMPARE_COMPLETED', 'IS_HOME_VALUE_COMPARE_COMPLETED');
	define('CONFIG_HOME_VALUE_IS_BEST', 'HOME_VALUE:IS_BEST');
	define('CONFIG_IS_RENT_ESTIMATE_COMPLETED', 'IS_RENT_ESTIMATE_COMPLETED');
	
	define('CONFIG_GENERATE_FLAG_ISSUES', 'ISSUES:GENERATE_FLAG_ISSUES');
	define('IssuesNotFound','ISSUES_NOT_FOUND');
	define('IssuesFound','ISSUES_FOUND');
	define('CONFIG_IS_HOME_VALUE_IS_BEST_SET', 'IS_HOME_VALUE_IS_BEST_SET');
	
	define('CONFIG_IS_CURRENT_MONTH_VARIANCE_COMPLETED', 'IS_CURRENT_MONTH_VARIANCE_COMPLETED');
	define('CONFIG_VARIANCE_2', 'HOME_VALUE_VARIANCE:CURRENT_MONTH_HOME_VALUE_VARIANCE_DIFFERENCE');
	define('CONFIG_SEND_MONTHY_REPORT', 'HOME_VALUE_VARIANCE:SEND_MONTHY_REPORT');
	define('PREVIOUS_MONTH', $PreviouseMonth);
	define('PREVIOUS_YEAR', $PreviouseYear);
	define('CONFIG_IS_PREV_MONTH_VARIANCE_COMPLETED', 'IS_PREV_MONTH_VARIANCE_COMPLETED');
	define('CONFIG_VARIANCE_3', 'HOME_VALUE_VARIANCE:PREVIOUS_MONTH_HOME_VALUE_VARIANCE_DIFFERENCE');
	define('PUB_ASSESSMENT_EXTERNAL_API', 'pub_assessment_external_api');

	define('INSIGHTS_PROPERTY_SOURCE', 'insights_main');
	

	define('CONFIG_GET_PROPERTIES_TO_BE_FETCHED_FOR_ASSESSMENT', 'ATTOM_API:GET_PROPERTIES_TO_BE_FETCHED_FOR_ASSESSMENT');
	define('AttomAssessmentAdded','ATTOM_ASSESSMENT_ADDED');
	define('AttomAssessmentUpdated','ATTOM_ASSESSMENT_UPDATED');
	define('DataNotReturnedByApi','DATA_NOT_RETURNED_BY_API');
	define('ATOM_ASSESSMENT_ENDPOINT', 'https://search.onboard-apis.com/propertyapi/v1.0.0/assessment/detail');
	define('AttomAVMAdded','ATTOM_AVM_ADDED');
	 define('AttomAVMUpdated','ATTOM_AVM_UPDATED');
	 define('AttomSalesMortgageHistoryAdded','ATTOM_SALES_MORTGAGE_HISTORY_ADDED');
	 define('AttomSalesMortgageHistoryUpdated','ATTOM_SALES_MORTGAGE_HISTORY_UPDATED');
 
	 define('CheckedForMortgage','CHECKED_FOR_MORTGAGE_UPDATE');
	 define('AttomAVMFetched','ATTOM_AVM_FETCHED');
	
	define('AttomAVMNotFetched','ATTOM_AVM_NOT_FETCHED');
	define('ATOM_SALES_HISTORY_ENDPOINT', 'https://search.onboard-apis.com/propertyapi/v1.0.0/saleshistory/expandedhistory');
	define('CONFIG_GET_ABB_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH', 'ATTOM_API:GET_ABB_UPSC_ADDRESS_TO_BE_FETCHED_FOR_PD_AND_SH');
	define('ATOM_AVM_ENDPOINT', 'https://search.onboard-apis.com/propertyapi/v1.0.0/attomavm/detail');



	### Home Value ###
	$InsightsFilesArray=[
		'/inbestments-php-cron/cma-external-api.php'
		 
	];
	$InsightCronFile = $_SERVER['SCRIPT_NAME'];
	$serverVar='production';
	if(in_array($InsightCronFile,$InsightsFilesArray))
	{
		$serverVar='development';
	}		
	define('IS_SERVER_VARIABLE', $serverVar);


	define('CONFIG_GET_INB_SUBJECT_PROPERTIES_CUSTOM', 'HOME_VALUE_CUSTOM:GET_INB_SUBJECT_PROPERTIES');
	define('CONFIG_GET_NON_INB_SUBJECT_PROPERTIES_CUSTOM', 'HOME_VALUE_CUSTOM:GET_NON_INB_SUBJECT_PROPERTIES');
	define('CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES_CUSTOM', 'HOME_VALUE_CUSTOM:GET_EXTERNAL_SUBJECT_PROPERTIES');
	define('CONFIG_PROCESS_HOME_VALUE_CUSTOM', 'HOME_VALUE_CUSTOM:PROCESS_HOME_VALUE');
	define('CONFIG_GET_UPDATE_PRICE_PROPERTIES_AS_BEST_CUSTOM', 'HOME_VALUE_CUSTOM:UPDATE_PRICE_PROPERTIES_AS_BEST');
	define('CONFIG_UPDATE_ADJUSTMENT_PRICE_CUSTOM', 'HOME_VALUE_CUSTOM:UPDATE_ADJUSTMENT_PRICE');
	define('CONFIG_IS_HOME_VALUE_COMPARE_COMPLETED_CUSTOM', 'IS_HOME_VALUE_CUSTOM_COMPARE_COMPLETED');
	define('CONFIG_HOME_VALUE_IS_BEST_CUSTOM', 'HOME_VALUE_CUSTOM:IS_BEST');

		// Rent-Restimate ::  tbl_insights_cron_function_frequency.cron_function_name
	define('CONFIG_GET_INB_SUBJECT_PROPERTIES_FOR_RENT', 'RENT_ESTIMATE:GET_INB_SUBJECT_PROPERTIES_FOR_RENT');
	define('CONFIG_GET_NON_INB_SUBJECT_PROPERTIES_FOR_RENT', 'RENT_ESTIMATE:GET_NON_INB_SUBJECT_PROPERTIES_FOR_RENT');
	define('CONFIG_GET_EXTERNAL_SUBJECT_PROPERTIES_FOR_RENT', 'RENT_ESTIMATE:GET_EXTERNAL_SUBJECT_PROPERTIES_FOR_RENT');
	define('CONFIG_PROCESS_RENT_VALUE', 'RENT_ESTIMATE:PROCESS_RENT_VALUE');
	define('CONFIG_IS_RENTAL_EXTERNAL_API_CHECKED_FOR_RENT', 'IS_CUSTOM_EXTERNAL_API_CHECKED_FOR_RENT');
	define('CONFIG_IS_RENTAL_EXTERNAL_API_CHECKED', 'IS_RENTAL_EXTERNAL_API_CHECKED');
	define('CONFIG_IS_RENTAL_EXTERNAL_API_RE_CHECKED', 'IS_RENTAL_EXTERNAL_API_RE_CHECKED');
	define('CONFIG_IS_HOME_EXTERNAL_API_CHECKED', 'IS_HOME_EXTERNAL_API_CHECKED');


	 // MLS
	 define('MlsCronStatus','MLS_CRON_STATUS');
	 define('MlsCronStatusPriceEstInProcess','1_price_est_in_process');
 
	 // 1_price_est_incomplete => Processed but not enough comps, so is_best is not set.
	 define('MlsCronStatusPriceEstInComplete','1_price_est_incomplete');
 
	 define('MlsCronStatusPriceEstCompleted','1_price_est_completed');
	 define('MlsCronStatusRentEstInProcess','2_rent_est_in_process');
 
	 // 2_rent_est_incomplete => Processed but not enough comps, so is_best is not set.
	 define('MlsCronStatusRentEstInComplete','2_rent_est_incomplete');
 
	 define('MlsCronStatusRentEstExternalFailed','2_rent_est_external_failed');
	 define('MlsCronStatusHomeEstExternalFailed','2_home_est_external_failed');
	 define('MlsCronStatusRentEstCompleted','2_rent_est_completed');
	 
	 // 2_rent_est__external_completed => Used when the rent estimation from External completed.
	 define('MlsCronStatusRentEstExternalCompleted','2_rent_est_external_completed');
	 define('MlsCronStatusHomeEstExternalCompleted','2_home_est_external_completed');
	 
	 define('MlsCronStatusAVMPriceInProcess','3_avm_price_in_process');
	 define('MlsCronStatusAVMRentInProcess','3_avm_rent_in_process');
	 define('MlsCronStatusAVMPriceInComplete','3_avm_price_processed_not_set');
	 define('MlsCronStatusAVMRentInComplete','3_avm_rent__processed_not_set');
	 define('MlsCronStatusAVMPriceCompleted','3_avm_price_completed');
	 define('MlsCronStatusAVMRentCompleted','3_avm_rent_completed');
 
	 // Not Using these statuses as we have splitted the process statuses to (Price & Rent)
	 define('MlsCronStatusAVMInProcess','3_avm_in_process');
	 define('MlsCronStatusAVMInComplete','3_avm_incomplete');
	 define('MlsCronStatusAVMCompleted','3_avm_completed');
	 define('MlsCronStatusIsBestInProcess','4_is_best_in_process');
	 define('MlsCronStatusIsBestInComplete','4_is_best_incomplete');
	 define('MlsCronStatusIsBestCompleted','4_is_best_completed');
	 // Not Using these statuses as we have splitted the process statuses to (Price & Rent)
 
	 define('MlsCronStatusIsBestPriceInProcess','4_is_best_price_in_process');
	 define('MlsCronStatusIsBestRentInProcess','4_is_best_rent_in_process');
	 define('MlsCronStatusIsBestPriceInComplete','4_is_best_price_processed_not_set');
	 define('MlsCronStatusIsBestRentInComplete','4_is_best_rent__processed_not_set');
	 define('MlsCronStatusIsBestPriceCompleted','4_is_best_price_completed');
	 define('MlsCronStatusIsBestRentCompleted','4_is_best_rent_completed');
 
	 define('MlsCronStatusJavaProcessInProcess','5_java_processor_in_processs');
	 define('MlsCronStatusJavaProcessCompleted','5_java_processor_completed');

	 	// External-Properties ::  tbl_insights_cron_function_frequency.cron_function_name
	//define('CONFIG_GET_PROPERTIES_FOR_EXTERNAL_API', 'EXTERNAL_API:GET_PROPERTIES_FOR_EXTERNAL_API');
	
	// External-Properties :: tbl_insights_cron_function_status.cron_function_status_flag
	define('AddressFoundInExternal','ADDRESS_FOUND_IN_EXTERNAL');
	define('AddressNotFoundInExternal','ADDRESS_NOT_FOUND_IN_EXTERNAL');
	define('RentalValueFoundInExternal','RENTAL_VALUE_FOUND_IN_EXTERNAL');
	define('HomeValueFoundInExternal','HOME_VALUE_FOUND_IN_EXTERNAL');
	define('RentalValueNotFoundInExternal','RENTAL_VALUE_NOT_FOUND_IN_EXTERNAL');
	define('HomeValueNotFoundInExternal','HOMEL_VALUE_NOT_FOUND_IN_EXTERNAL');

	define('MLS_PROPERTY_SOURCE', 'tbl_property_details_mls');


	define('LOW_LISTPRICE', 250000);
	define('HIGH_LISTPRICE', 450000);
	// --------------------------------------------------------------------------------------------------------------------------------------//

?>
