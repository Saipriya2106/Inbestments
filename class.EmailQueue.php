<?php
class EmailQueue{
    public static function GetMailPropertiesByOrganisationId($mailType, $organizationId) {
        $Obj = new SqlManager();
	    $Obj->AddTbls(array('mail_properties'));
    	$Obj->AddFlds(array('*'));
		$Obj->AddFldCond('mail_type', $mailType);
	    $Obj->AddFldCond('organization_id', $organizationId);
    	return $Obj->GetSingle();
	}
    public static function AddToQueueAsArray($Data) {
		if (!isset($Data['process_at']) || $Data['process_at'] == '' || $Data['process_at'] == null || $Data['process_at'] == '0000-00-00 00:00:00')
			$Data['process_at'] = date(DB_DATETIME_FORMAT);
		
		if (isset($Data['cc'])) {
			if (is_array($Data['cc']))
				$Data['cc'] = json_encode($Data['cc']);
		} else
			$Data['cc'] = json_encode(array());
		
		if (isset($Data['bcc'])) {
			if (is_array($Data['bcc']))
				$Data['bcc'] = json_encode($Data['bcc']);
		}
		
		if (isset($Data['user_var'])) {
			if (is_array($Data['user_var']))
				$Data['user_var'] = json_encode($Data['user_var']);
		} else
			$Data['user_var'] = json_encode(array());
		
		if (!isset($Data['name'])) {
			$Data['name'] = '';
		}
		
		if (!isset($Data['user_id'])) {
			$Data['user_id'] = 0;
		}
		
		if (!isset($Data['config_src'])) {
			$Data['config_src'] = 0;
		}
		
		if (!isset($Data['config_id'])) {
			$Data['config_id'] = 0;
		}
		
		$Obj = new SqlManager();
		$Obj->AddTbls('email_queue');
		$Obj->AddInsrtFlds($Data);
		$QueueId = $Obj->InsertSingle();
		
		if ($QueueId != 'E') {
			$Obj = new SqlManager();
			$Obj->AddTbls('email_content');
			$Obj->AddInsrtFlds(array('email_queue_id' => $QueueId, 'content' => $Data['content']));
				
			$Res = $Obj->InsertSingle();
			if ($Res === 'E')
				return false;
			else {
				try {
					// After the data is inserted into email_content table 
					// call the cron job file to process the emails immediately
					include dirname(__DIR__).'/INBESTMENTS/cron.email.php';
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				return true;
			}
		} else
			return false;
	}
    public static function GetMailsToBeSent() {
		$Obj = new SqlManager();
        $Obj->AddTbls(array('email_queue ec', 'email_content eq'));
        $Obj->AddFlds(array('eq.id', 'ec.content', 'ec.subject', 'ec.email_to', 'ec.cc', 'ec.bcc', 'ec.reply_to', 'ec.name', 'ec.config_id', 'ec.config_src', 'ec.user_var', 'ec.from_name', 'ec.mail_purpose'));
        $Obj->AddTblCond('ec.id', 'eq.email_queue_id');
        $Obj->AddFldCond('ec.status', 'pending');
        $Obj->AddLimit(0, 13);
        $Res = $Obj->GetMultiple();
		
		$TempConfig = array_column($Res, 'config_id');
		$TempConfigArray = self::GetMailGunConfigById(array_unique($TempConfig));
		$ConfigArray = array();
		
		foreach ($TempConfigArray as $Item)
			$ConfigArray[$Item['id']] = $Item;
		
		$ProcessingIds = array();
		foreach ($Res as $Item)
			$ProcessingIds[] = $Item['id'];
		
		if (count($ProcessingIds)) {
			$Obj = new SqlManager();
			$Obj->AddTbls('email_queue');
			$Obj->AddInsrtFlds(array('status' => 'P'));
			$Obj->AddFldCond('id', $ProcessingIds, 'IN');
			$Obj->Update();
		}
		
		return array('data' => $Res, 'config' => $ConfigArray);
	}
    public static function GetMailProperties($mailType) {
		$Obj = new SqlManager();
		$Obj->AddTbls(array('mail_properties'));
		$Obj->AddFlds(array('*'));
		$Obj->AddFldCond('mail_type', $mailType);
		return $Obj->GetSingle();
	}
    public static function GetMailGunConfigById($Id) {
		$Obj = new SqlManager();
		$Obj->AddTbls('mailgun_tag_campaign');
		$Obj->AddFlds('*');
		$Obj->AddFldCond('id', $Id, 'IN');
		$Obj->AddFldCond('status', 'A');
		return $Obj->GetMultiple();
	}
}