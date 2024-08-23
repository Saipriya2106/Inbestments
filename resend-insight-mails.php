<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
header('Content-type: application/json');

ob_start();
ini_set('memory_limit', '-1');

require_once 'config.php';
require_once 'class.SIMonthlyEmailsForContacts.php';
require_once 'class.Common.php';
require_once 'class.EmailMarketing.php';
require_once 'class.EmailTemplate.php';
require_once 'class.EmailQueue.php';
require_once 'SqlManager.php';


//Common::callExternalAPI("https://betteruptime.com/api/v1/heartbeat/Sy6NVQvs6C96H4YxCHMdKdaG", 'POST', "");
echo "Started At: " . date(DB_DATETIME_FORMAT) . "\n";
// Get the raw JSON data from the request body
$json_data = file_get_contents('php://input');
// echo '$json_data: ';
// print_r($json_data);
// echo "\n";

// Decode the JSON data into an associative array
$request_data = json_decode($json_data, true);

$resendWelcomeEmail = $request_data['resendWelcomeEmail'] ?? false;
$resendMonthlyEmail = $request_data['resendMonthlyEmail'] ?? false;
$insights = $request_data['insights'] ?? false;
echo '$request_data: ';
print_r($request_data);
echo "\n";
echo '$_REQUEST: ';
print_r($_REQUEST);
echo "\n";
echo '$resendWelcomeEmail: ';
print_r($resendWelcomeEmail);
echo "\n";
echo '$resendMonthlyEmail: ';
print_r($resendMonthlyEmail);
echo "\n";
echo '$insights: ';
print_r($insights);
echo "\n";

try {
    if (!is_array($insights) || count($insights) === 0) {
        throw new Exception('Insights must be a non-empty array');
    }
    if (!$resendWelcomeEmail && !$resendMonthlyEmail) {
        throw new Exception('Mail type is required');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo 'Caught exception while resend mails : ',  $e->getMessage(), "\n";
    exit;
} finally {
    try {
        if ($resendWelcomeEmail) {
            //SIMonthlyEmailsForContacts::ProcessWelcomeEmails($insights);
        }
        /*
        if ($resendMonthlyEmail) {
           // SIMonthlyEmailsForContacts::ProcessMonthlyEmails($insights, CURRENT_MONTH, CURRENT_YEAR, null, true);
        }
        foreach ($insights as $insight) {
            echo '$insight[insights_guid]';
            print_r($insight['insights_guid']);
            echo '$insight[dont_send_email]';
            print_r($insight['dont_send_email']);
            $guId = $insight['insights_guid'];
            $currentValue = $insight['dont_send_email'];
            //SIMonthlyEmailsForContacts :: UpdateDontSendEmailFlag($guId, $currentValue, $resendWelcomeEmail, $resendMonthlyEmail);
        }
            */
    } catch (Exception $e) {
        http_response_code(500);
        echo 'Caught exception while resend mails : ',  $e->getMessage(), "\n";
        exit;
    } finally {
        http_response_code(200);
       // echo 'Sent insight mails successfully';
    }
}
    
echo "Finished At: " . date(DB_DATETIME_FORMAT) . "\n";