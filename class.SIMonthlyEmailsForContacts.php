<?php
class SIMonthlyEmailsForContacts
{
    public static function SendWelcomeEmails($Month, $Year)
    {
        echo "Send welcome emails";
        $Insights = self::FetchInsightsToBeEmailedForWelcome($Month, $Year);
        echo '<pre>';
        print_r($Insights);
        // die('Stopped@1');
        self::ProcessWelcomeEmails($Insights);
    }
    private static function FetchInsightsToBeEmailedForWelcome($Month, $Year)
    {
        $Obj = new SqlManager();
        $Query = "SELECT 
        im.insights_property_id insights_property_id, `guid` insights_guid, im.agent_id, im.lender_id, im.primary_owner_id,im.property_src, 
        CONCAT(TRIM(im.property_address), 
        IF(im.unit_number != '', CONCAT('#', im.unit_number), ''), ', ', im.property_city, ', ', im.property_state, ' ', im.property_zipcode) address, u.email_address, u.organization_id 
        FROM 
            insights_main im
        LEFT JOIN users u ON u.id = im.primary_owner_id    
        LEFT JOIN insights_contacts_welcome_email cm ON(im.insights_property_id = cm.insights_property_id) 
        WHERE 
      
       im.uploaded_datetime >='2021-04-01 12:24:43' 
       
        AND im.insights_property_id NOT IN (SELECT cwe.insights_property_id FROM insights_contacts_welcome_email cwe)
         " . CONFIG_PROPERTY_CONDITION_WITH_ALIAS . " " . AUTOMATION_CONDITION_WITH_ALIAS . "
        AND (dont_send_email NOT IN('W','WM') OR dont_send_email IS NULL OR dont_send_email = '')
		ORDER BY  im.insights_property_id DESC
        LIMIT 5 ";

        return $Obj->GetQuery($Query);
    }
    private static function FetchContactsMultiple($InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_contacts c', 'insights_property_contact_mapping cm'));
        $Obj->AddFlds(array('c.id', 'c.contact_first_name', 'c.contact_last_name', 'c.contact_email', 'cm.contact_type', 'cm.insight_report_frequency'));
        $Obj->AddFldCond('cm.insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('cm.is_subscribed', 'Y');
        $Obj->AddFldCond('cm.contact_type', 'B');
        // $Obj->AddTblCond('c.insights_property_id', 'cm.insights_property_id');
        $Obj->AddTblCond('c.id', 'cm.contact_id');
        return $Obj->GetMultiple();
    }
    private static function TrackContactsEmail($Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_contacts_monthly_email'));
        $Obj->AddInsrtFlds($Data);
        $Obj->InsertSingle();
    }
    private static function TrackWelcomeEmail($Data)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_contacts_welcome_email'));
        $Obj->AddInsrtFlds($Data);
        $Obj->InsertSingle();
    }
    public static function ProcessWelcomeEmails($Insights)
    {
        echo "PrcessWelcomeEmails";
        
        echo '$_SESSION';
        print_r($_SESSION);
        
        $DomainName = (isset($_SESSION["DOMAIN_NAME"]) && $_SESSION["DOMAIN_NAME"] != '') ? $_SESSION["DOMAIN_NAME"] : '';
        $DomainUrl = (isset($_SESSION["DOMAIN_URL"]) && $_SESSION["DOMAIN_URL"] != '') ? $_SESSION["DOMAIN_URL"] : '';
        $DomainLogo = (isset($_SESSION["DOMAIN_LOGO"]) && $_SESSION["DOMAIN_LOGO"] != '') ? $_SESSION["DOMAIN_LOGO"] :'';
        $SocialFb = (isset($_SESSION["DOMAIN_SOCIAL_FACEBOOK"]) && $_SESSION["DOMAIN_SOCIAL_FACEBOOK"] != '') ? $_SESSION["DOMAIN_SOCIAL_FACEBOOK"] : '';
        $SocialTwitter = (isset($_SESSION["DOMAIN_SOCIAL_TWITTER"]) && $_SESSION["DOMAIN_SOCIAL_TWITTER"] != '') ? $_SESSION["DOMAIN_SOCIAL_TWITTER"] :'';
        $SocialLinkedIn = (isset($_SESSION["DOMAIN_SOCIAL_LINKEDIN"]) && $_SESSION["DOMAIN_SOCIAL_LINKEDIN"] != '') ? $_SESSION["DOMAIN_SOCIAL_LINKEDIN"] :'';
        $CustomWebLink = ($DomainName == "InBestments") ? $DomainUrl . "#!/" : $DomainUrl;
        
        foreach ($Insights as $Insight) {
            $Parms = array(
                'cron_function_name' => CONFIG_IS_WELCOME_EMAIL_SENT, 'insights_property_id' => $Insight['insights_property_id'],
                'cron_function_status_flag' => 'Y', 'tp_api' => 'N',  'month' => CURRENT_MONTH, 'year' => CURRENT_YEAR
            );
            $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms, false);

            $Contacts = self::FetchContactsMultiple($Insight['insights_property_id']);

           // var_dump($Contacts);
            
            if (count($Contacts)) {
                
                self::TrackWelcomeEmail(
                    array(
                        'insights_property_id' => $Insight['insights_property_id'],
                    )
                );
                
                $agentFullName = '';
                foreach ($Contacts as $Contact) {
                    print_r($Contact);
                    $sender_role = '';
                    $EmailContents = "";
                    $welcomeTemplate = 'insights-contact-welcome-email';
                    if ($Insight['primary_owner_id'] > 0) {
                        $welcomeTemplate = 'insights-contact-welcome-email-custom'; 
                        $EmailContentsRecord = self::GetEmailContents($Insight['primary_owner_id'], 'smart-insight-welcome-email');
                        echo '$EmailContentsRecord';
                        var_dump($EmailContentsRecord);
                        if (!empty($EmailContentsRecord)) {
                            $EmailContents = $EmailContentsRecord['body_text'];
                            echo '$EmailContents';
                            var_dump($EmailContents);
                        } else {
                            $welcomeTemplate = 'insights-contact-welcome-email';
                        }
                    } 
                    else {
                        $welcomeTemplate = 'insights-contact-welcome-email';
                    }
                    // print_r($EmailContents);
                    // die('@@@@2'); 
                    
                    if ($Insight['primary_owner_id'] > 0) {
                        if ($Insight['agent_id'] > 0 && $Insight['agent_id'] == $Insight['primary_owner_id']) {
                            $ALDetails = EmailMarketing::GetUsersAgentDetails($Insight['agent_id'], true);
                            $sender_role = 'Agent';
                            $agentFullName = trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name']);
                        } else if ($Insight['lender_id'] > 0 && $Insight['lender_id'] == $Insight['primary_owner_id']) {
                            $ALDetails = EmailMarketing::GetUsersLenderDetails($Insight['lender_id'], true);
                            $sender_role = 'Lender';
                        } else if ($Insight['lender_id'] > 0) {
                            $ALDetails = EmailMarketing::GetUsersLenderDetails($Insight['lender_id'], true);
                            $sender_role = 'Lender';
                        }
                    } else {
                        if ($Insight['agent_id'] > 0) {
                            $ALDetails = EmailMarketing::GetUsersAgentDetails($Insight['agent_id'], true);
                            $sender_role = 'Agent';
                            $agentFullName = trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name']);
                        } else {
                            $ALDetails = EmailMarketing::GetUsersLenderDetails($Insight['lender_id'], true);
                            $sender_role = 'Lender';
                        }
                    }
                    
                    $mlsText = ($Insight['agent_id'] > 0) ? '' : ' | NMLS#' . $ALDetails['mls_id'];

                    $ShowProfileImage = 'none';
                    if ($ALDetails['profile_image_file'] != '')
                        $ShowProfileImage = 'table-cell';

                    $ShowCompanyLogo = 'none';
                    if ($ALDetails['company_logo_file'] != '')
                        $ShowCompanyLogo = 'table-cell';

                    $ALDetailWidth = '75%';
                    if ($ALDetails['profile_image_file'] != '' && $ALDetails['company_logo_file'] != '')
                        $ALDetailWidth = '50%';

                    echo "<hr>welcomeTemplate:" . $welcomeTemplate . "<hr>";

                    //var_dump($ALDetails);
                    /*
                    if (preg_match('/@bricksFolios/i', $Insight['email_address'])) {

                        // $templateName = 'insights-contact-monthly-email-bricksfolios';
                        $DomainLogo = DOMAIN_LOGO_BRICKSFOLIO;
                        $DomainName = DOMAIN_NAME_BRICKSFOLIO;
                        $DomainUrl = DOMAIN_URL_BRICKSFOLIO;
                        $CustomWebLink = $DomainUrl;
                    }*/
                    
                    if (count($ALDetails)) {
                        $ALDetailHtml = EmailTemplate::GetMailContent(
                            'agent-detail',
                            array(
                                'baseUrl' => APP_URL,
                                'profileImage' => $ALDetails['profile_image_file'],
                                'agentName' => trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name']),
                                'MlsNo' => $mlsText,
                                'officeName' => $ALDetails['company'],
                                'agentPhone' => $ALDetails['mobile_number'],
                                'agentEmailId' => $ALDetails['email_address'],
                                'companyLogo' => $ALDetails['company_logo_file'],
                                'socialNetworkingDetails' => '',
                                'showProfileImage' => $ShowProfileImage,
                                'showCompanyLogo' => $ShowCompanyLogo,
                                'agentDetailWidth' => $ALDetailWidth,
                               // 'CUSTOM_APP_URL' => CUSTOM_APP_URL,

                            )
                        );
                    } else {
                        $ALDetailHtml = '';
                    }
                  
                    
                    $InsightContactHtml = EmailTemplate::GetMailContent($welcomeTemplate, array(
                        'baseUrl' => APP_URL,
                        'contactFirstName' => $Contact['contact_first_name'],
                        'address' => $Insight['address'],
                        'agentFullName'=>$agentFullName,
                        'guID' => $Insight['insights_guid'],
                        'alDetail' => $ALDetailHtml,
                        'DomainName' => $DomainName,
                        'DomainUrl' => $DomainUrl,
                        'DomainLogo' => $DomainLogo,
                        'SocialFb' => $SocialFb,
                        'SocialTwitter' => $SocialTwitter,
                        'SocialLinkedIn' => $SocialLinkedIn,
                        'CustomWebLink' => $CustomWebLink,
                        'DotLogo' => DOT_LOGO,
                        'FacebookLogo' => FACEBOOK_LOGO,
                        'TwitterLogo' => TWITTER_LOGO,
                        'LinkedInLogo' => LINKEDIN_LOGO,
                        'EmailContents' => $EmailContents

                        )
                    );
                    $sender_id = 0;
                    if (isset($Insight['primary_owner_id']) && $Insight['primary_owner_id'] > 0) {
                        $sender_id = $Insight['primary_owner_id'];
                    } else if (isset($ALDetails['user_id']) && $ALDetails['user_id']) {
                        $sender_id = $ALDetails['user_id'];
                    }
                    $MailPurpose = 'si_welcome_email';
                    $MailType = 'Transactional';
                    /*
                    if ($Insight['organization_id'] == 2) {
                        $MailPurpose = 'si_welcome_email_bricksfolios';
                        $MailType = 'BF-Transactional';
                    }
                    */
                    $MailProperties = EmailQueue::GetMailPropertiesByOrganisationId($MailType, $Insight['organization_id']);
                    // print_r($InsightContactHtml);
                    echo '<pre>';
                    print_r($InsightContactHtml);
                    
                    // die("stopped#222");
                    $QueueStatus = EmailQueue::AddToQueueAsArray(
                        //  'email_to' =>$Contact['contact_email'],
                        array(
                            'email_to' => $Contact['contact_email'],
                            'from_name' => trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name']),
                            'user_id' => 0,
                            'mail_purpose' => $MailPurpose,
                        //    'mail_source' => $MailProperties['mail_domain'],
                            'name' => $Contact['contact_first_name'],
                            'subject' => $Contact['contact_first_name'] . " - Welcome to InBestments Smart Insights",
                            'content' => $InsightContactHtml,
                            'config_src' => 1,
                            'config_id' => 20,
                            'cc' => array(),
                            'reply_to' => $ALDetails['email_address'],
                            'user_var' => array(
                                'date' => date(DB_DATE_FORMAT),
                                'insights_property_id' => $Insight['insights_property_id'],
                                'agent_id' => $Insight['agent_id'],
                                'lender_id' => $Insight['lender_id'],
                                'contact_id' => $Contact['id'],
                                'sender_role' => $sender_role,
                                'sender_id' => $sender_id
                            )
                        )
                    );
                 
                   
    
                }

                // echo "Email Queued!!";

            }
        }
    }
    private static function GetEmailContents($PrimaryOwnerId, $EmailTemplateType)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('email_template_master'));
        $Obj->AddFlds('*');
        // $Obj->AddFldCond('created_by', $PrimaryOwnerId);
        $Obj->AddFldCond('template_for', $EmailTemplateType);
        $Obj->AddFldCond('is_active', 1);
        return $Obj->GetSingle();
    }
    public static function SendMonthlyEmails($Month, $Year)
    {
       
        $Insights = self::FetchInsightsToBeEmailed($Month, $Year);
        echo 'MonthlyReportRecord:: ';
        echo '<pre>';
        print_r($Insights);
        self::ProcessMonthlyEmails($Insights, $Month, $Year);
    }
    private static function FetchInsightsToBeEmailed($Month, $Year)
    {
        $RandomLimit = rand(10, 30);
       

        $Obj = new SqlManager();
     
        $Query = "SELECT 
        im.inbestments_property_id id, im.insights_property_id insights_property_id, `guid` insights_guid, 
        im.agent_id, im.lender_id, im.primary_owner_id, 
        CONCAT(TRIM(im.property_address), IF(im.unit_number != '', CONCAT('#', im.unit_number), ''), ', ', im.property_city) address, u.email_address, u.organization_id
        FROM 
            insights_main im 
        LEFT JOIN insights_send_mail_status isms ON isms.insights_property_id = im.insights_property_id
		LEFT JOIN users u ON u.id = im.primary_owner_id
        WHERE 
            isms.mail_type = '" . SEND_MONTHLY_REPORT . "'    AND isms.send_mail = 'Y'        
            " . AUTOMATION_CONDITION_WITH_ALIAS . "  AND im.insights_property_id NOT IN (	SELECT cms.insights_property_id FROM insights_contacts_monthly_email cms,insights_main im WHERE cms.insights_property_id = im.insights_property_id  AND email_month = '" . $Month . "'  AND email_year = " . $Year . "  group by cms.insights_property_id ) 
            AND (dont_send_email NOT IN('M','WM') OR dont_send_email IS NULL OR dont_send_email = '') 
	    ORDER BY im.insights_property_id desc";
        


       return $Obj->GetQuery($Query);
    }
    public static function ProcessMonthlyEmails($Insights, $Month, $Year, $isUserInputRequest = null, $isResend = null)
    {
        echo 'Processing monthly emails';
        $DomainName = (isset($_SESSION["DOMAIN_NAME"]) && $_SESSION["DOMAIN_NAME"] != '') ? $_SESSION["DOMAIN_NAME"] : '';
        $DomainUrl = (isset($_SESSION["DOMAIN_URL"]) && $_SESSION["DOMAIN_URL"] != '') ? $_SESSION["DOMAIN_URL"] : '';
        $DomainLogo = (isset($_SESSION["DOMAIN_LOGO"]) && $_SESSION["DOMAIN_LOGO"] != '') ? $_SESSION["DOMAIN_LOGO"] :'';
        $CustomWebLink = ($DomainName == "InBestments") ? $DomainUrl . "#!/" : $DomainUrl;

        $SocialFb = (isset($_SESSION["DOMAIN_SOCIAL_FACEBOOK"]) && $_SESSION["DOMAIN_SOCIAL_FACEBOOK"] != '') ? $_SESSION["DOMAIN_SOCIAL_FACEBOOK"] : '';
        $SocialTwitter = (isset($_SESSION["DOMAIN_SOCIAL_TWITTER"]) && $_SESSION["DOMAIN_SOCIAL_TWITTER"] != '') ? $_SESSION["DOMAIN_SOCIAL_TWITTER"] :'';
        $SocialLinkedIn = (isset($_SESSION["DOMAIN_SOCIAL_LINKEDIN"]) && $_SESSION["DOMAIN_SOCIAL_LINKEDIN"] != '') ? $_SESSION["DOMAIN_SOCIAL_LINKEDIN"] : '';

        $MonthName = date('F');
        foreach ($Insights as $Insight) {

            $EstimatedPrice = [];
            if ($isResend) {
                $EstimatedPrice = self::FetchEstimatedPriceForResend($Insight['insights_property_id']);
            } else {
                $EstimatedPrice = self::FetchEstimatedPrice($Insight['insights_property_id'], $Month, $Year);
            }
            // print_r($EstimatedPrice);
            if (count($EstimatedPrice)) {
                $Contacts = self::FetchContactsMultiple($Insight['insights_property_id']);

                //   print_r($Contacts);

                if (count($Contacts)) {
                    foreach ($Contacts as $Contact) {
                        // print_r($Contact);
                        $Is_Report_Send = 'N';
                        $insight_report_frequency = ($Contact['insight_report_frequency'] == '' || $Contact['insight_report_frequency'] == null) ? 'Monthly' : $Contact['insight_report_frequency'];
                        $insights_property_id = $Insight['insights_property_id'];
                        if ($insight_report_frequency != 'Monthly') {
                            $Is_Report_Send = self::CheckFrequencyStatus($insight_report_frequency, $insights_property_id);
                        } else {
                            $Is_Report_Send = 'Yes';
                        }
                        //$Is_Report_Send='Yes';
                        if ($Is_Report_Send = 'Yes') {
                            // die('Stopped@2.1');
                            print_r($Contact);
                            $sender_role = '';
                            $textForAgent1 = '';
                            $textForAgent2 = '';
                            $textForAgent3 = '';
                            $textForAgent4 = '';
                            $textForAgent5 = '';

                            $textForLender1 = '';
                            $textForNMLS = '';
                            
                            self::TrackContactsEmail(
                                array(
                                    'insights_property_id' => $Insight['insights_property_id'],
                                    'email_month' => $Month,
                                    'email_year' => $Year,
                                    'email_address' => $Contact['contact_email'],
                                )
                            );

                        //    $UpdateSendMailStatus = Common::UpdateSendMailStatus($Insight['insights_property_id'], SEND_MONTHLY_REPORT, 'N');
                            $Parms = array(
                                'cron_function_name' => CONFIG_IS_MONTHLY_EMAIL_SENT, 'insights_property_id' => $Insight['insights_property_id'],
                                'cron_function_status_flag' => 'Y', 'tp_api' => 'N',  'month' => CURRENT_MONTH, 'year' => CURRENT_YEAR
                            );
                       //     $UpdateMappedPropertiesWithInbestments = Common::InsertData('insights_cron_function_status', $Parms, false);
                            
                            $EmailContents = "";
                            $EmailSubject = "";
                            if ($Insight['primary_owner_id'] > 0) {
                                $templateName = 'insights-contact-monthly-email-custom';
                                $EmailContentsRecord = self::GetEmailContents($Insight['primary_owner_id'], 'smart-insight-monthly-report-email');
                                if (!empty($EmailContentsRecord)) {
                                    $EmailContents = $EmailContentsRecord['body_text'];
                                    $EmailSubject = $EmailContentsRecord['subject'];
                                    echo "<hr>EmailContents:<hr>";
                                } else {
                                    $templateName = 'insights-contact-monthly-email';
                                }
                            } else {
                                $templateName = 'insights-contact-monthly-email';
                            }
                            echo "<hr>templateName:" . $templateName . "<hr>";
                            // $templateName = 'insights-contact-monthly-email';
                            if ($Insight['primary_owner_id'] > 0) {
                                if ($Insight['primary_owner_id'] == 32) {
                                    // $textForNMLS='NMLS#1977929';
                                }
                                
                                if ($Insight['primary_owner_id'] == 2422 || $Insight['primary_owner_id'] == 1192) {
                                    $textForNMLS = '';
                                }
                                if ($Insight['agent_id'] > 0 && $Insight['agent_id'] == $Insight['primary_owner_id']) {
                                    $ALDetails = EmailMarketing::GetUsersAgentDetails($Insight['agent_id'], true);
                                    $sender_role = 'Agent';
                                } else if ($Insight['lender_id'] > 0 && $Insight['lender_id'] == $Insight['primary_owner_id']) {
                                    $ALDetails = EmailMarketing::GetUsersLenderDetails($Insight['lender_id'], true);
                                    $sender_role = 'Lender';
                                }
                            } 
                            if (($Insight['primary_owner_id'] > 0)&&($Insight['agent_id'] > 0)){
                                if ($Insight['agent_id'] > 0) {

                                    echo '$EmailMArketting';
                                    $ALDetails = EmailMarketing::GetUsersAgentDetails($Insight['agent_id'], true);
                                    echo 'ALDetails';
                                    print_r($ALDetails);
                                    $sender_role = 'Agent';
                                } else {
                                    $ALDetails = EmailMarketing::GetUsersLenderDetails($Insight['lender_id'], true);
                                    $sender_role = 'Lender';
                                }
                            }
                            /*
                            if (preg_match('/@bricksFolios/i', $Insight['email_address'])) {

                                // $templateName = 'insights-contact-monthly-email-bricksfolios';
                                $DomainLogo = DOMAIN_LOGO_BRICKSFOLIO;
                                $DomainName = DOMAIN_NAME_BRICKSFOLIO;
                                $DomainUrl = DOMAIN_URL_BRICKSFOLIO;
                                $CustomWebLink = $DomainUrl;
                            }
                            */
                            $mlsText = ($Insight['agent_id'] > 0) ? '' : ' | NMLS#' . $ALDetails['mls_id'];
                            $ShowProfileImage = 'none';
                            if ($ALDetails['profile_image_file'] != '')
                                $ShowProfileImage = 'table-cell';

                            $ShowCompanyLogo = 'none';
                            if ($ALDetails['company_logo_file'] != '')
                                $ShowCompanyLogo = 'table-cell';

                            $ALDetailWidth = '75%';
                            if ($ALDetails['profile_image_file'] != '' && $ALDetails['company_logo_file'] != '')
                                $ALDetailWidth = '50%';

                            if (count($ALDetails)) {

                                $ALDetailHtml = EmailTemplate::GetMailContent(
                                    'agent-detail',
                                    array(
                                        'baseUrl' => APP_URL,
                                        'profileImage' => $ALDetails['profile_image_file'],
                                        'agentName' => trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name'] . ' ' . $textForNMLS),
                                        'MlsNo' => $mlsText,
                                        'officeName' => $ALDetails['company'],
                                        'agentPhone' => $ALDetails['mobile_number'],
                                        'agentEmailId' => $ALDetails['email_address'],
                                        'companyLogo' => $ALDetails['company_logo_file'],
                                        'socialNetworkingDetails' => '',
                                        'showProfileImage' => $ShowProfileImage,
                                        'showCompanyLogo' => $ShowCompanyLogo,
                                        'agentDetailWidth' => $ALDetailWidth,
                                     //   'CUSTOM_APP_URL' => CUSTOM_APP_URL,
                                    )
                                );
                            } else {
                                $ALDetailHtml = '';
                            }



                            // echo '<hr>'.$DomainName." :: ".$CustomWebLink."<hr>";

                            $InsightContactHtml = EmailTemplate::GetMailContent(
                                $templateName,
                                array(
                                    'baseUrl' => APP_URL,
                                    'contactFirstName' => $Contact['contact_first_name'],
                                    'textForAgent1' => $textForAgent1,
                                    'textForAgent2' => $textForAgent2,
                                    'textForAgent3' => $textForAgent3,
                                    'textForAgent4' => $textForAgent4,
                                    'textForAgent5' => $textForAgent5,
                                    'textForLender1' => $textForLender1,
                                    'currentMonth' => $MonthName,
                                    'address' => $Insight['address'],
                                    'guID' => $Insight['insights_guid'],
                                    'alDetail' => $ALDetailHtml,
                                  //  'CUSTOM_APP_URL' => CUSTOM_APP_URL,
                                    'DomainName' => $DomainName,
                                    'DomainUrl' => $DomainUrl,
                                    'DomainLogo' => $DomainLogo,
                                    'SocialFb' => $SocialFb,
                                    'SocialTwitter' => $SocialTwitter,
                                    'SocialLinkedIn' => $SocialLinkedIn,
                                    'CustomWebLink' => $CustomWebLink,
                                    'DotLogo' => DOT_LOGO,
                                    'FacebookLogo' => FACEBOOK_LOGO,
                                    'TwitterLogo' => TWITTER_LOGO,
                                    'LinkedInLogo' => LINKEDIN_LOGO,
                                    'EmailContents' => $EmailContents

                                )
                            );
                            $sender_id = 0;
                            if (isset($Insight['primary_owner_id']) && $Insight['primary_owner_id'] > 0) {
                                $sender_id = $Insight['primary_owner_id'];
                            } else if (isset($ALDetails['user_id']) && $ALDetails['user_id']) {
                                $sender_id = $ALDetails['user_id'];
                            }

                            $MailPurpose = 'si_monthly_report_email';
                            $MailType = 'Transactional';
                            
                            $MailProperties = EmailQueue::GetMailPropertiesByOrganisationId($MailType, $Insight['organization_id']);

                            // echo '<pre>';
                            // print_r($InsightContactHtml);
                            // die("stopped#111");
                            $QueueStatus = EmailQueue::AddToQueueAsArray(
                                array(
                                    'email_to' => $Contact['contact_email'],
                                    'from_name' => trim($ALDetails['first_name'] . ' ' . $ALDetails['last_name']),
                                    'user_id' => 0,
                                    'name' => $Contact['contact_first_name'],
                                    'subject' => $isUserInputRequest ? 'Ready now: '.$EmailSubject. $Insight['address'] : $EmailSubject. $Insight['address'],
                                    'content' => $InsightContactHtml,
                                    'config_src' => 1,
                                    'mail_purpose' => $MailPurpose,
                                    'mail_source' => $MailProperties['mail_domain'],
                                    'config_id' => 16,
                                    'cc' => array(),
                                    'reply_to' => $ALDetails['email_address'],
                                    'user_var' => array(
                                        'date' => date(DB_DATE_FORMAT),
                                        'insights_property_id' => $Insight['insights_property_id'],
                                        'agent_id' => $Insight['agent_id'],
                                        'lender_id' => $Insight['lender_id'],
                                        'contact_id' => $Contact['id'],
                                        'sender_role' => $sender_role,
                                        'sender_id' => $sender_id,
                                        'is_repeat' => 'N',
                                        'email_month' => $Month,
                                        'email_year' => $Year,
                                        'is_subscriber' => 'N',
                                    )
                                )
                            );
                            if (!$isResend) {
                              die("stopped#3333");
                            }
                        }
                        // die("stopped");

                    }
                }
            }
        }
    }
    private static function FetchEstimatedPriceForResend($InsightsPropertyID)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_new_programmatic'));
        $Obj->AddFlds('*');
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('is_best', 'Y');

        return $Obj->GetSingle();
    }
    private static function FetchEstimatedPrice($InsightsPropertyID, $Month, $Year)
    {
        $Obj = new SqlManager();
        $Obj->AddTbls(array('insights_est_price_new_programmatic'));
        $Obj->AddFlds('*');
        $Obj->AddFldCond('insights_property_id', $InsightsPropertyID);
        $Obj->AddFldCond('est_month', $Month);
        $Obj->AddFldCond('est_year', $Year);

        return $Obj->GetSingle();
    }
    public static function CheckFrequencyStatus($InsightReportFrequency, $InsightsPropertyId)
    {
        $IsSendReport = 'No';
        $GetLastReportSentDate = self::GetLastReportSentDate($InsightsPropertyId);
        print_r($GetLastReportSentDate);
        if (count($GetLastReportSentDate)) {
            $SentAt = $GetLastReportSentDate[0]['sent_at'];
            $CurrentMonth = date("n");
            $CurrentYear = date("Y");

            $SentAtMonth = date("n", strtotime($SentAt));
            $SentAtYear = date("Y", strtotime($SentAt));
            if ($InsightReportFrequency == 'Quarterly') {
                $CurrentYearQuarter = ceil($CurrentMonth / 3);
                $SentAtYearQuarter = ceil($SentAtMonth / 3);
                if ($CurrentYear == $SentAtYear) {
                    if ($CurrentYearQuarter != $SentAtYearQuarter) {
                        $IsSendReport = 'Yes';
                    }
                } else {
                    $IsSendReport = 'Yes';
                }
            } else if ($InsightReportFrequency == 'Half-Yearly') {
                $CurrentHalfYear = ceil($CurrentMonth / 6);
                $SentAtHalfYear = ceil($SentAtMonth / 6);
                if ($CurrentYear == $SentAtYear) {
                    if ($CurrentHalfYear != $SentAtHalfYear) {
                        $IsSendReport = 'Yes';
                    }
                } else {
                    $IsSendReport = 'Yes';
                }
            } else if ($InsightReportFrequency == 'Yearly') {
                if ($CurrentYear != $SentAtYear) {
                    $IsSendReport = 'Yes';
                }
            }
        } else {
            $IsSendReport = 'Yes';
        }

        return $IsSendReport;
    }
    public static function GetLastReportSentDate($InsightsPropertyId)
    {
        $Obj = new SqlManager();
        $Query = "SELECT * FROM insights_contacts_monthly_email WHERE insights_property_id IN (" . $InsightsPropertyId . ") ORDER BY sent_at DESC LIMIT 1";
        return $Obj->GetQuery($Query);
    }






    
    
    
    
    



}


?>
