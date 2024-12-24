<?php
require_once 'curl.php';

// Fetch Device Info from /html/ssmp/deviceinfo/deviceinfocut.asp
function fetchDeviceInfo($cookies) {
    $url = ONT_URL . '/html/ssmp/deviceinfo/deviceinfocut.asp';
    return curlRequest($url, null, $cookies);
}

// Fetch Optic Info from /html/amp/opticinfo/opticinfo.asp
function fetchOpticInfo($cookies) {
    $url = ONT_URL . '/html/amp/opticinfo/opticinfo.asp';
    return curlRequest($url, null, $cookies);
}
?>
