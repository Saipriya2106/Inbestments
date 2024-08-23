<?php
	ini_set('memory_limit', '-1');
	//include 'config.php';
	
	require_once 'class.EmailQueue.php';
	
	
	 ob_start();
	 echo '\n \n <pre>';
	 echo "Started At: ".date('Y-m-d H:i:s')."\n";
     echo '<br>';
	

	$mailTypes=array(); 
	
	$mailTypes=array(
		['mail_type'=>'BF-Transactional','mail_purpose'=>'si_welcome_email_bricksfolios' ],
		['mail_type'=>'BF-Transactional','mail_purpose'=>'si_monthly_report_email_bricksfolios' ],
		['mail_type'=>'Transactional','mail_purpose'=>'si_welcome_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'si_monthly_report_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'si_issue_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'promotion_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'si_repeat_monthly_report_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'si_monthly_report_subscriber_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'si_target_rate_email' ],
		['mail_type'=>'Marketing','mail_purpose'=>'new_lead_email' ],
		['mail_type'=>'Marketing','mail_purpose'=>'hot_deals_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'saved_search_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'matching_properties_search_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'la_cha_properties_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'selected_properties_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'past_clients_email' ],
		['mail_type'=>'Transactional','mail_purpose'=>'invalid_property_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'account_activation' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'email_verify_otp' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'referral_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'welcome_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'welcome_non_buyer' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'reset_password' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'inviting_agents' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'contact_agent_email' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'agent_contact_received_email' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'contact_mvp_agent_email' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'profile_ca_to_our_address' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'broker_email' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'direct_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'lender_email' ], 
		['mail_type'=>'Marketing','mail_purpose'=>'property_contact_mvp_agent' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'channel_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_join_through_lead' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'join_inbestments_smart_insights' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_join_through_invite' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_join_through_invite_homeowner' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_unsubscription' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_verify_this' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insight_contact_agent_lender' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_target_rate' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'send_achived_target_rate' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'insights_contact_advisor' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'send_recommendation_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'contact_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'property_management_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'makeoffer_portfolio' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'make_offer' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'contact_agent' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'download_ebook' ], 		
		['mail_type'=>'Transactional','mail_purpose'=>'add_team_member' ],	
		['mail_type'=>'Transactional','mail_purpose'=>'si_home_value_lower_email' ], 
		['mail_type'=>'Transactional','mail_purpose'=>'si_user_input_generate_email' ],
		['mail_type'=>'BF-Marketing','mail_purpose'=>'removed_campaign' ],
		['mail_type'=>'BF-Marketing','mail_purpose'=>'leasing_active_campaign' ],
		['mail_type'=>'BF-Marketing','mail_purpose'=>'leasing_sold_campaign' ],
		['mail_type'=>'BF-Marketing','mail_purpose'=>'leasing_campaign' ]
	); 

	$Res = EmailQueue::GetMailsToBeSent();
	//echo '#1::';
	//print_r($Res['data']);
	/*exit;*/
	
	// print_r($Res['data']);
	
	if (count($Res['data'])) {
		$ch = curl_init();
		
		//echo '<pre>';
		$UpdateArray = array();
		foreach ($Res['data'] as $Item) {
			$mailType='Marketing';
			foreach ($mailTypes as $key => $value) {
				if($value['mail_purpose'] == $Item['mail_purpose']){
					$mailType=$value['mail_type']; 
				}
			}

			$GetMailProperties=EmailQueue::GetMailProperties($mailType);
		
			$Item['content'] = str_replace(array('�', "\r\n", "�??", "�"), array('&copy;', "\n", "<br/><br/>", ''), $Item['content']);			
			//$Item['content'] = base64_encode($Item['content']);
			//$Item['content'] = utf8_encode($Item['content']);
			
			$PostFields = array('html' => $Item['content'], 'subject' => $Item['subject'], 'cc' => $Item['cc'], 'bcc' => $Item['bcc']);
			
			if ($Item['name'] != null && $Item['name'] != '')
				$PostFields['to'] = $Item['name'].' <'.$Item['email_to'].'>';
			else
				$PostFields['to'] = $Item['email_to'];
			
			if ($Item['from_name'] != null && $Item['from_name'] != '')
				$PostFields['from_name'] = $Item['from_name'];
			
			if ($Item['config_id'] != 0 && count($Res['config'])) {
				if (isset($Res['config'][$Item['config_id']])) {
					$CurrentConfig = $Res['config'][$Item['config_id']];
					if ($CurrentConfig['tag'] != null && $CurrentConfig['tag'] != '')
						$PostFields['o:tag'] = $CurrentConfig['tag'];
					if ($CurrentConfig['campaign_key'] != null && $CurrentConfig['campaign_key'] != '')
						$PostFields['o:campaign'] = $CurrentConfig['campaign_key'];
				}
			}

			if ($Item['user_var'] != null && $Item['user_var'] != '' && $Item['user_var'] != '[]') {
				$PostFields['v:inb_tracking'] = '"'.$Item['user_var'].'"';
			}

			if ($Item['reply_to'] != null && $Item['reply_to'] != '') {
				$PostFields['reply_to'] = $Item['reply_to'];
			}
			
			
			$PostFields['mail_type'] = $mailType;
			$PostFields['domain'] = $GetMailProperties['mail_domain'];
		//	$PostFields['mail_from'] = $GetMailProperties['mail_from'];
			

			echo '::tbl_email_queue->id:: '.$Item['id'];
			//print_r($Item['id']);
	
			echo "Data for API";
			//var_dump(json_encode($PostFields));
			curl_setopt($ch, CURLOPT_URL, 'http://localhost:5500/send-email');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json'
				)
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($PostFields));
			/*
			$Response = curl_exec($ch);
           
			$StatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			$ResponseArray = json_decode($Response, true);
			echo '<br>ResponseArray:<br>'; 
			print_r($ResponseArray);
			$Status = 'E';
			if (isset($ResponseArray['success'])) {
				$Status = 'S';
				echo '<br>Mail sent successfully.'.$Item['id'].'<br>'; 
			}
			echo '$Response';
			print_r(json_decode($Response, true));
			print_r($StatusCode);
			
			$UpdateArray[] = array('email_queue_id' => $Item['id'], 's_at' => date(DB_DATETIME_FORMAT),'status' => $Status, 'response' => json_encode($ResponseArray['data']));
			//break;
            */
		}
		/*
		curl_close($ch);
		echo '<br>$UpdateArray:<br>'; 
        if(isset($ResponseArray['success'])) {
		if (count($UpdateArray)) {
			echo '<br>$UpdateArray:<br>2'; 
			print_r($UpdateArray);
			foreach ($UpdateArray as $Item) {
				$Obj = new SqlManager();
				$Obj->AddTbls('email_queue');
				$Obj->AddInsrtFlds(array('status' => $Item['status'], 'sent_at' => $Item['s_at'], 'response' => $Item['response']));
				$Obj->AddFldCond('id', $Item['email_queue_id']);
				$Obj->Update();
			}			
		}
        }*/
	}	


		 echo '<br>';
		 echo "Ended At: ".date('Y-m-d H:i:s')."\n";
         $logDir = 'D:\LSITC204\Xampp\htdocs\Inbestments\cron-log';
         if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true); // Create directory if not exists
        }
		$logPathFile = $logDir . DIRECTORY_SEPARATOR . date('Y-m-d') . '-cron.email-api-log.txt';
        if (file_put_contents($logPathFile, ob_get_contents(), FILE_APPEND | LOCK_EX) === false) {
            echo "Failed to write to file: $logPathFile";
            exit;
        }

		 ob_end_flush();
?>