<?php
require_once 'login.php';
require_once 'data.php';
require_once 'data_parsers.php';

// Global cookies storage
$ont_cookies = null;

function fetchWithRetry($fetchFunction) {
    global $username, $password, $ont_cookies;

    while (true) {
        $result = $fetchFunction($ont_cookies);
        
        if ($result && strlen($result) >= 1024) {
            return $result;
        }

        echo "Fetch failed or incomplete. Re-logging in...\n";

        // Infinite loop until successful login
        while (true) {
            sleep(60);  // Wait for 60 seconds before retrying
            $ont_cookies = performLogin($username, $password);
            
            if ($ont_cookies) {
                echo "Re-login successful.\n";
                break;
            }

            echo "Re-login failed. Retrying...\n";
        }
    }
}

// Function to handle login, fetch, and parsing
function fetchAllData() {
    global $username, $password, $ont_cookies;

    // Perform initial login only if cookies are null
    if ($ont_cookies === null) {
        while (true) {
            $ont_cookies = performLogin($username, $password);

            if ($ont_cookies) {
                echo "Initial login successful.\n";
                break;
            }

            echo "Initial login failed. Retrying...\n";
            sleep(10);
        }
    }

    // Fetch and parse data
    $deviceInfoRaw = fetchWithRetry('fetchDeviceInfo');
    $opticInfoRaw = fetchWithRetry('fetchOpticInfo');

    $combinedData = [
        'DeviceInfo' => parseDeviceInfo($deviceInfoRaw),
        'OpticInfo' => parseOpticInfo($opticInfoRaw)
    ];

    echo $combinedData ? "Parsed Data:\n" . print_r($combinedData, true) : "Failed to parse data.\n";

    return $combinedData;
}

if (!isset($DISABLE_EXAMPLE_USAGE)) {

while (true) {
    fetchAllData();
    sleep(1);
}

}

?>
