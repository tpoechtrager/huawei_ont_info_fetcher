<?php
// Parse Device Info from HTML/JS
function parseDeviceInfo($htmlInput) {
    $data = [];

    // Match stDeviceInfo block from JavaScript
    preg_match('/new stDeviceInfo\((.*?)\)/', $htmlInput, $deviceMatch);

    if (!empty($deviceMatch[1])) {
        $params = explode(',', $deviceMatch[1]);
        $data['Device'] = [
            'Path' => trim($params[0] ?? '', '"'),
            'SerialNumber' => trim($params[1] ?? '', '"'),
            'FirmwareVersion' => decodeJSString($params[2] ?? ''),
            'SoftwareVersion' => trim($params[3] ?? '', '"'),
            'Model' => decodeJSString($params[4] ?? ''),
            'Vendor' => trim($params[5] ?? '', '"'),
            'ManufactureDate' => decodeJSString($params[6] ?? ''),
            'MAC' => decodeJSString($params[7] ?? ''),
            'Description' => decodeJSString($params[8] ?? ''),
            'ProductID' => decodeJSString($params[9] ?? '')
        ];
    }

    // Parse CPU and Memory Usage (from HTML tags or JavaScript variables)
    preg_match('/cpuUsed\s*=\s*[\'"](\d+%)?[\'"]/', $htmlInput, $cpuMatch);
    preg_match('/memUsed\s*=\s*[\'"](\d+%)?[\'"]/', $htmlInput, $memMatch);

    $data['CPU_Usage'] = $cpuMatch[1] ?? 'Unknown';
    $data['Memory_Usage'] = $memMatch[1] ?? 'Unknown';

    return $data;
}

// Parse Optic Info from HTML/JS
function parseOpticInfo($htmlInput) {
    $data = [];

    // Match stOpticInfo block from JavaScript
    preg_match('/new stOpticInfo\((.*?)\)/', $htmlInput, $opticMatch);

    if (!empty($opticMatch[1])) {
        $params = explode(',', $opticMatch[1]);

        $data['Optic'] = [
            'Path' => trim($params[0] ?? '', '"'),
            'Status' => trim($params[1] ?? '', '"'),
            'TX_Current' => decodeJSString($params[2] ?? ''),
            'RX_Power' => decodeJSString($params[3] ?? ''),
            'Bias_Current' => trim($params[4] ?? '', '"'),
            'Temperature' => trim($params[5] ?? '', '"'),
            'Voltage' => trim($params[6] ?? '', '"'),
            'Warnings' => decodeJSString($params[7] ?? ''),
            'Errors' => decodeJSString($params[8] ?? ''),
            'Vendor' => decodeJSString($params[9] ?? ''),
            'SerialNumber' => decodeJSString($params[10] ?? ''),
            'DateCode' => trim($params[11] ?? '', '"'),
            'TxWaveLength' => trim($params[12] ?? '', '"'),
            'RxWaveLength' => trim($params[13] ?? '', '"'),
            'MaxTxDistance' => trim($params[14] ?? '', '"'),
            'LosStatus' => trim($params[15] ?? '', '"')
        ];
    }
    return $data;
}

// Decode JavaScript escape sequences like \x2e to "."
function decodeJSString($str) {
    return preg_replace_callback('/\\\\x([0-9A-Fa-f]{2})/', function($match) {
        return chr(hexdec($match[1]));
    }, trim($str, '" '));
}
?>
