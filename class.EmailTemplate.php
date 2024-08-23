<?php
class EmailTemplate {
    public static function GetMailTemplate($TemplateName) {
    	$Content = file_get_contents('email-template/'.$TemplateName.'.html', true);
    	return $Content;
    }
    
	/***
	*  $content_replace_array => 
	* 		ARRAY KEYS	 => CONTAIN ALL THE REPLACE KEYS
	*		ARRAY VALUE  => CONTAIN ALL THE REPLACE VALUE
	*/   
	public static function GetMailContent($TemplateName, $ContentReplaceArray = array()) {
		$MailTemplate = self::GetMailTemplate($TemplateName);
		
		// KEY REPLACEMENT FOR MAIL CONTENT
		/*$ContentReplaceKey 			= self::AddKeyPrefixSuffix(array_keys($ContentReplaceArray));
		$ContentReplaceVal 			= array_values($ContentReplaceArray);
      	$MailTemplate = str_replace($ContentReplaceKey, $ContentReplaceVal, $MailTemplate);
      	
		return $MailTemplate;*/
		return self::CompileContent($MailTemplate, $ContentReplaceArray);
    }
    
    public static function CompileContent($TemplateContent, $ContentReplaceArray) {
    	$ContentReplaceKey 			= self::AddKeyPrefixSuffix(array_keys($ContentReplaceArray));
    	$ContentReplaceVal 			= array_values($ContentReplaceArray);
    	$MailTemplate = str_replace($ContentReplaceKey, $ContentReplaceVal, $TemplateContent);
    	 
    	return $MailTemplate;
    }
	
	public static function AddKeyPrefixSuffix($ReplaceKey){
		foreach($ReplaceKey as $Index => $Item)
			$ReplaceKey[$Index] = "{{".$Item."}}";
		return $ReplaceKey;
	}
}
?>