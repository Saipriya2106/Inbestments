<?php 
class SIFlagIssues{
    public static function InsertIssue($Row)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_issues'));
        $Obj->AddInsrtFlds($Row);
        $Obj->InsertSingle();
    }

    public static function CheckInsightIssues($Row)
    {
        for ($i=0; $i < count($Row) ; $i++) { 
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_issues'));
            $Obj->AddFlds(array('id'));
            $Obj->AddTblCond('insights_property_id', $Row[$i]['insights_property_id']);
            $Obj->AddFldCond('issue_description', $Row[$i]['issue_description']);
            $Obj->AddFldCond('issues_present', $Row[$i]['issues_present']);
            $issueData = $Obj->GetSingle();

            if(!$issueData){
                SIFlagIssues::InsertIssue($Row[$i]);
            }
        }
    }
    public static function CallFlagIssues($GenerateFlagIssuesActive)
    {
        if($GenerateFlagIssuesActive)
        {
            self::FlagIssues();
        }
    } 
    public static function UpdateInsightIssuesForAddressFound($insights_property_id)
    {
            $Obj = new SqlManager();
            $Obj->AddTbls(array('insights_issues'));
            $Obj->AddInsrtFlds(array('issues_present' => 'N','modified_by_role' => 'System', 'modified_by_user' => 0));
            $Obj->AddTblCond('insights_property_id', $insights_property_id);
            $Obj->AddFldCond('issue_description', 'Address not found');
            $Obj->AddFldCond('issues_present', 'Y');
            $Obj->Update();
    }
    public static function FlagIssues()
    {
        $Month = date('m');
        $Year = date('Y');
        $Properties = self::GetInsightsMain($Month, $Year);
        foreach ($Properties as $Property) {
            $Issues = array();

            if ($Property['Square Foot'] == null || $Property['Square Foot'] == 0) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Square Foot',
                    'issue_found_date' => date(DB_DATETIME_FORMAT),
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Year Built'] == null || $Property['Year Built'] == 0) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Year Built',
                    'issue_found_date' => date(DB_DATETIME_FORMAT),
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Purchase Price'] == null || $Property['Purchase Price'] == 0) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Purchase Price',
                    'issue_found_date' => date(DB_DATETIME_FORMAT),
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Sold Date'] == null || $Property['Sold Date'] == '1800-01-01 00:00:00' || $Property['Sold Date'] == '0000-00-00 00:00:00') {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Sold Date',
                    'issue_found_date' => date(DB_DATETIME_FORMAT),
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Beds'] == null || $Property['Beds'] == 0) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Beds',
                    'issue_found_date' => date(DB_DATETIME_FORMAT), 
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Baths'] == null || $Property['Baths'] == 0) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Baths',
                    'issue_found_date' => date(DB_DATETIME_FORMAT),
                    'is_mandatory_for_home_value' => 'Y'
                );
            }

            if ($Property['Home Value'] == null) {
                $Issues[] = array(
                    'insights_property_id' => $Property['insights_property_id'],
                    'issues_present' => 'Y',
                    'issue_description' => 'Home Value',
                    'issue_found_date' => date(DB_DATETIME_FORMAT)
                );
            }

            function checkMandatoryIssue ($Issue) {
                if ($Issue['issues_present'] == 'Y' && $Issue['is_mandatory_for_home_value'] == 'Y')
                    return true;
                else
                    return false;    
            }
            $mandatoryIssues = array_filter($Issues, "checkMandatoryIssue");

            if (count($Issues)) {
                self::CheckInsightIssues($Issues);
            }

            if (count($Issues) && count($mandatoryIssues)) {
      
             //   $UpdateSendMailStatus = Common::UpdateSendMailStatus($Property['insights_property_id'], SEND_MONTHLY_REPORT, 'N');
                print_r('ISSUES_SEND_MAIL_SET_N');
    
                $Parms = array('cron_function_name' => CONFIG_GENERATE_FLAG_ISSUES, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => IssuesFound,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);  

            } else {
                
            //    $UpdateSendMailStatus = Common::UpdateSendMailStatus($Property['insights_property_id'], SEND_MONTHLY_REPORT, 'N');

                $Parms = array('cron_function_name' => CONFIG_GENERATE_FLAG_ISSUES, 'insights_property_id' => $Property['insights_property_id'], 
                'cron_function_status_flag' => IssuesNotFound,  'month' =>CURRENT_MONTH, 'year' =>CURRENT_YEAR );  
                $UpdateMappedPropertiesWithInbestments=Common::InsertData('insights_cron_function_status', $Parms,false);                  
            }
        }
    }
    
    public static function GetInsightsMain($Month, $Year, $SendEmail = null)
    {
        $Obj = new SqlManager();

        if ($SendEmail == null)
            $SECondition = "im.send_email IS NULL";
        else if ($SendEmail == 'N')
            $SECondition = "im.send_email = 'N'";

        $Query = "SELECT 
        im.guid, 
        im.insights_property_id,
        CONCAT(TRIM(im.property_address), ' ', IF(im.unit_number != '', CONCAT('#', im.unit_number, ' '), ''), im.property_city, ', ', im.property_state, ' ', im.property_zipcode) address,
        IF(mls.square_foot IS NOT NULL AND mls.square_foot > 0, mls.square_foot, IF(ap.living_size IS NOT NULL AND ap.living_size > 0, ap.living_size, eu.living_square_foot)) `Square Foot`,
        IF(mls.year_built IS NOT NULL AND mls.year_built > 0, mls.year_built, IF(ap.summary_year_built  IS NOT NULL AND ap.summary_year_built  > 0, ap.summary_year_built , eu.year_built)) `Year Built`,
        IF(mls.sold_price IS NOT NULL AND mls.sold_price > 0, mls.sold_price, IF(tblSmh.sold_price IS NOT NULL AND tblSmh.sold_price > 0, tblSmh.sold_price, eu.sold_last_for)) `Purchase Price`,
        IF(
        mls.sold_date IS NOT NULL AND mls.sold_date != DATE('1800-01-01 00:00:00') AND mls.sold_date != DATE('0000-00-00 00:00:00'), 
        mls.sold_date, 
        IF(tblSmh.sold_date IS NOT NULL AND tblSmh.sold_date != DATE('0000-00-00 00:00:00'), tblSmh.sold_date, eu.sold_last_on)) `Sold Date`,
        IF(mls.bedroom_count IS NOT NULL AND mls.bedroom_count > 0, mls.bedroom_count, IF(ap.beds IS NOT NULL AND ap.beds > 0, ap.beds, eu.bedrooms)) `Beds`,
        IF(mls.bathroom_count IS NOT NULL AND mls.bathroom_count > 0, mls.bathroom_count, IF(ap.baths_total IS NOT NULL AND ap.baths_total > 0, ap.baths_total, eu.bathrooms)) `Baths`,
        COUNT(mb.insights_property_id) `Number of Mortgages`,
        SUM(mb.origination_loan_amount) `Total Mortgage Amount`,
        ep.est_price `Home Value`,
        ep.pcomp_criteria_id,
        ep.criteria,
        im.agent_id,
        im.lender_id,
        mls.status
        FROM
        insights_main im 
        LEFT JOIN property_details_mls mls ON (mls.id = im.inbestments_property_id)
        LEFT JOIN insights_attom_property ap ON (ap.insights_property_id = im.insights_property_id AND (im.inbestments_property_id IS NULL OR im.inbestments_property_id = 0))
        LEFT JOIN insights_mortgage_balance mb ON (mb.insights_property_id = im.insights_property_id)
        LEFT JOIN insights_est_price_new_programmatic ep ON (ep.insights_property_id = im.insights_property_id AND ep.is_best = 'Y' AND ep.est_month = '".$Month."' AND ep.est_year = ".$Year.")
        LEFT JOIN insights_property_details_by_user eu ON (eu.insights_property_id = im.insights_property_id)

        LEFT JOIN (SELECT sale_rec_date sold_date, sale_amt sold_price, insights_property_id FROM 
        (SELECT sale_rec_date, sale_amt, insights_property_id FROM insights_attom_sales_mortgage_history WHERE sale_amt > 0 AND sale_trans_type = 'Resale' ORDER BY sale_rec_date DESC)
        AS smh GROUP BY smh.insights_property_id)
        AS tblSmh ON(tblSmh.insights_property_id = im.insights_property_id)

        WHERE
        im.record_status != 'R'
        AND im.checked_in_inbestments = 'Y'
        AND im.checked_for_inbestments_avm = 'Y'
        ".CONFIG_PROPERTY_CONDITION_WITH_ALIAS." ".AUTOMATION_CONDITION_WITH_ALIAS."
        AND im.insights_property_id NOT IN (SELECT icfs.insights_property_id FROM insights_cron_function_status icfs 
        LEFT JOIN  insights_cron_function_frequency icf ON icf.cron_function_name = icfs.cron_function_name WHERE 
        icfs.cron_function_name='".CONFIG_GENERATE_FLAG_ISSUES."'  AND  icf.cron_function_frequency='Monthly' AND 
        icfs.month=". CURRENT_MONTH." AND  icfs.year=".CURRENT_YEAR."  )        
        AND ".$SECondition."
        ORDER BY im.insights_property_id DESC
        ";
        //  GROUP BY im.insights_property_id
               
       // print_r($Query);
        return $Obj->GetQuery($Query);
    }


}