/*
<?php 
/*
function authorizeRequest() {
    $username = 'Saipriya'; 
    $password = 'Saipriya'; 

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        header('WWW-Authenticate: Basic');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Authorization Required';
        exit;
    }

    $provided_username = $_SERVER['PHP_AUTH_USER'];
    $provided_password = $_SERVER['PHP_AUTH_PW'];

    if ($provided_username !== $username || $provided_password !== $password) {
        header('WWW-Authenticate: Basic');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid credentials';
        exit;
    }
}
function getPathParameters() {
    $path = $_SERVER['REQUEST_URI'];
    $pathParts = explode('/', $path);
    
    // Remove empty elements and script name or base path
    $pathParts = array_values(array_filter($pathParts));

    // Remove the script name from path parts if present
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $scriptNameParts = explode('/', $scriptName);
    $basePathLength = count($scriptNameParts) - 1;
    $pathParts = array_slice($pathParts, $basePathLength);

    return $pathParts;
}

// Call this function at the beginning of your script
//authorizeRequest();
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


$pathParams = getPathParameters();

// Example: Assuming your URL structure is http://localhost/your-script.php/param1/param2
$param1 = isset($pathParams[0]) ? $pathParams[0] : null;
$param2 = isset($pathParams[1]) ? $pathParams[1] : null;


echo "Path Parameter 1: $param1\n";
echo "Path Parameter 2: $param2\n";
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
*/

for ($i = 0 ,$j=1;$j<=30,$i <=20; $i++,$j++) {
    
    echo $i.' '.$j;
    var_dump(0);
}













































/*
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
header('Content-type: application/json');

// Retrieve headers
$resendWelcomeEmail = $_SERVER['HTTP_RESEND_WELCOME_EMAIL'] ?? false;
$resendMonthlyEmail = $_SERVER['HTTP_RESEND_MONTHLY_EMAIL'] ?? false;
$insight1Guid = $_SERVER['HTTP_INSIGHT1_GUID'] ?? null;
$insight1DontSendEmail = $_SERVER['HTTP_INSIGHT1_DONT_SEND_EMAIL'] ?? false;
$insight2Guid = $_SERVER['HTTP_INSIGHT2_GUID'] ?? null;
$insight2DontSendEmail = $_SERVER['HTTP_INSIGHT2_DONT_SEND_EMAIL'] ?? false;

// Example output
echo "Resend Welcome Email: " . $resendWelcomeEmail . "\n";
echo "Resend Monthly Email: " . $resendMonthlyEmail . "\n";
echo "Insight 1 Guid: " . $insight1Guid . "\n";
echo "Insight 1 Don't Send Email: " . $insight1DontSendEmail . "\n";
echo "Insight 2 Guid: " . $insight2Guid . "\n";
echo "Insight 2 Don't Send Email: " . $insight2DontSendEmail . "\n";

// Further processing based on headers
*/
?>