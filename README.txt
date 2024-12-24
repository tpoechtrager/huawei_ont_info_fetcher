Huawei ONT Info fetcher.

Only tested with EG8010Hv6-10 (BBOOE).

Adjust login and ONT_URL in config.php.
 
Example output:

php service.php
Login Payload: UserName=Epuser&PassWord=[INFO REMOVED]&Language=english&x.X_HW_Token=[INFO REMOVED]

Login successful!
Initial login successful.
Parsed Data:
Array
(
    [DeviceInfo] => Array
        (
            [Device] => Array
                (
                    [Path] => InternetGatewayDevice.DeviceInfo
                    [SerialNumber] => [INFO REMOVED]
                    [FirmwareVersion] => 2F7D.G
                    [SoftwareVersion] => V5R021C10S244
                    [Model] => EG8010Hv6-10
                    [Vendor] => HWTC
                    [ManufactureDate] => 2023-02-13_05:01:28
                    [MAC] => [INFO REMOVED]
                    [Description] => OptiXstar EG8010Hv6-10 GPON Terminal
                    [ProductID] => [INFO REMOVED]
                )

            [CPU_Usage] => 33%
            [Memory_Usage] => 20%
        )

    [OpticInfo] => Array
        (
            [Optic] => Array
                (
                    [Path] => InternetGatewayDevice.X_HW_DEBUG.AMP.Optic
                    [Status] => ok
                    [TX_Current] => 2.34
                    [RX_Power] => -13.62
                    [Bias_Current] => 3236
                    [Temperature] => 39
                    [Voltage] => 7
                    [Warnings] => --
                    [Errors] => --
                    [Vendor] => HUAWEI
                    [SerialNumber] => [INFO REMOVED]
                    [DateCode] => 231010
                    [TxWaveLength] => 1310
                    [RxWaveLength] => 1490
                    [MaxTxDistance] => 20
                    [LosStatus] => 0
                )

        )

)
