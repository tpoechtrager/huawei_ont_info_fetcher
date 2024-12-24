<?php
// Include login credentials and cURL functions
require_once 'config.php';
require_once 'curl.php';

// Fetch login token from /asp/GetRandCount.asp
function fetchLoginToken(&$cookies) {
    $url = ONT_URL . '/asp/GetRandCount.asp';
    $response = curlRequest($url, null, $cookies);

    // Remove BOM (if present)
    $response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    
    return trim($response);
}

// Perform the login request and check for sid
function performLogin($username, $password) {
    $cookies = [];
    $token = fetchLoginToken($cookies);

    if (!$token) {
        echo "Token not received\n";
        return false;
    }

    $url = ONT_URL . '/login.cgi';
    $passwordEncoded = base64_encode($password);

    // Construct payload matching the image
    $payload = http_build_query([
        'UserName' => $username,
        'PassWord' => $passwordEncoded,
        'Language' => 'english',
        'x.X_HW_Token' => $token
    ]);

    // Dump payload before submission
    echo "Login Payload: $payload\n\n";

    // Perform the request using the reusable curl function
    $response = curlRequest($url, $payload, $cookies);

    // Check if sid exists in cookies
    foreach ($cookies as $cookie) {
        if (strpos($cookie, 'sid=') !== false) {
            echo "Login successful!\n";
            return $cookies;  // Return cookies on success
        }
    }

    echo "Login failed: No session ID (sid) found.\n";
    return false;
}

?>
