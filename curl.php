<?php
function curlRequest($url, $postFields = null, &$cookies = []) {
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_HEADER => true,  // Capture response headers
    ];

    if ($postFields) {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = $postFields;
    }

    if (!empty($cookies)) {
        $options[CURLOPT_COOKIE] = implode('; ', $cookies);
    }

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        die("cURL Error: $err");
    }

    // Separate headers and body
    list($header, $body) = explode("\r\n\r\n", $response, 2);

    // Extract cookies from response headers
    if (preg_match_all('/^Set-Cookie:\s*([^;]+)/mi', $header, $matches)) {
        foreach ($matches[1] as $cookie) {
            $cookies[] = $cookie;
        }
    }

    return $body;
}
?>
