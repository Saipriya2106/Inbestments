<?php 
class EmailMarketing{
    public static function GetUsersAgentDetails($AgentId = 1, $IsUserID = false) {
        $Fields = array('u.id user_id', 'ad.agent_id', 'ad.mls_id', 'u.first_name first_name', 'u.last_name last_name', 'u.email_address', 'u.mobile_number', 'ad.company', 'ad.office_phone', 'ad.website', 'ad.social_net_details');
        $Obj = new SqlManager();
        $Obj->AddTbls(array('agent_details ad', 'users u'));
        $Obj->AddFlds($Fields);
        if ($IsUserID)
            $Obj->AddTblCond('ad.user_id', $AgentId);
        else
            $Obj->AddTblCond('ad.agent_id', $AgentId);
        $Obj->AddTblCond('ad.user_id', 'u.id');
        $Obj->AddFldCond('u.is_agent', 1);
        
        $Res = $Obj->GetSingle();
        
        $SocialArray = array();
        if (isset($Res['website']) && $Res['website'] != '') {
            if (strpos($Res['website'], 'http://') === false && strpos($Res['website'], 'https://') === false)
                $Web = 'https://'.$Res['website'];
            else
                $Web = $Res['website'];
            
            $SocialArray[] = array('url' => $Web, 'icon' => APP_URL.'images/icon-png/web-c.png');
        }
        
        if (isset($Res['social_net_details'])) {
            $TempSocDet = json_decode($Res['social_net_details'], true);
            
            foreach ($TempSocDet as $Item) {
                if ($Item['vl'] != null && $Item['vl'] != '') {
                    $Url = '';
                    /*
                    if ($Item['nm'] != 'whatsapp'
                        && $Item['nm'] != 'skype'
                        && $Item['nm'] != 'wechat') {
                        $Url = 'https://' . str_replace(array('https://', 'http://'), array('', ''), $Item['vl']);
                    } else if ($Item['nm'] == 'whatsapp') {
                        $Url = 'tel:' . $Item['vl'];
                    } else if ($Item['nm'] == 'skype') {
                        $Url = 'skype:' . $Item['vl'] + '?call';
                    } else if ($Item['nm'] == 'wechat') {
                        $Url = 'weixin://dl/chat?' . $Item['vl'];
                    }
                    */

                    if ($Url != '')
                        $SocialArray[] = array('url' => $Url, 'icon' => APP_URL.'images/icon-png/'.$Item['ic'].'-c.png');
                }
            }
        }
        
        $Res['social_details'] = $SocialArray;
        
        if (isset($Res['user_id'])) {
            $Obj = new SqlManager();
            $Obj->AddTbls('user_img');
            $Obj->AddFlds(array('profile_image_file', 'company_logo_file'));
            $Obj->AddFldCond('user_id', $Res['user_id']);
            $Img = $Obj->GetSingle();
            
            if (count($Img)) {
                if ($Img['profile_image_file'] != null && $Img['profile_image_file'] != '')
                    $Res['profile_image_file'] = OTHER_THAN_PROPERTIES_CLOUD_PATH.USER_IMAGE_PATH.'profile-image/'.$Img['profile_image_file'];
                else
                    $Res['profile_image_file'] = '';
                //APP_URL.'images/agent-default-image.png'
                if ($Img['company_logo_file'] != null && $Img['company_logo_file'] != '')
                    $Res['company_logo_file'] = OTHER_THAN_PROPERTIES_CLOUD_PATH.USER_IMAGE_PATH.'company-logo/'.$Img['company_logo_file'];
                else
                    $Res['company_logo_file'] = '';
            }
        }
        return $Res;
    }

    public static function GetUsersLenderDetails($LenderID, $IsUserID = false) {
        $Fields = array('u.id user_id', 'ld.lender_id', 'ld.individual_nmls_no mls_id', 'u.first_name first_name', 'u.last_name last_name', 'u.email_address','u.mobile_number mobile_number', 'ld.company company', 'ld.office_phone office_phone');
        $Obj = new SqlManager();
        $Obj->AddTbls(array('lender_details ld', 'users u'));
        $Obj->AddFlds($Fields);
        if ($IsUserID)
            $Obj->AddTblCond('ld.user_id', $LenderID);
        else
            $Obj->AddTblCond('ld.lender_id', $LenderID);
        $Obj->AddTblCond('ld.user_id', 'u.id');
        
        $Res = $Obj->GetSingle();

        echo '$GetLenderDetails';
        print_r($Res);
        
        if (isset($Res['user_id'])) {
            $Obj = new SqlManager();
            $Obj->AddTbls('user_img');
            $Obj->AddFlds(array('profile_image_file', 'company_logo_file'));
            $Obj->AddFldCond('user_id', $Res['user_id']);
            $Img = $Obj->GetSingle();
            
            if (count($Img)) {
                if ($Img['profile_image_file'] != null && $Img['profile_image_file'] != '')
                    $Res['profile_image_file'] = OTHER_THAN_PROPERTIES_CLOUD_PATH.USER_IMAGE_PATH.'profile-image/'.$Img['profile_image_file'];
                else
                    $Res['profile_image_file'] = '';
                //APP_URL.'images/agent-default-image.png'
                if ($Img['company_logo_file'] != null && $Img['company_logo_file'] != '')
                    $Res['company_logo_file'] = OTHER_THAN_PROPERTIES_CLOUD_PATH.USER_IMAGE_PATH.'company-logo/'.$Img['company_logo_file'];
                else
                    $Res['company_logo_file'] = '';
            }
        }
        echo  'Second$Res';
        print_r($Res);
        return $Res;
    }
}

?>