# VivaTerminal_IM30
PHP Class to use IM30 Terminal (BSD 3-Clause License)

This PHP code is to initiate and collect failed payments, correct payments are collected through the Viva Wallet webhook.

## How to use

Include the IM30 Class.

```
include_once "VivaTerminal_IM30.php";
```

Create IM30 Class Object
```
$hardware_os_terminal = new VivaTerminal_IM30();
```

Set Terminal Settings

Param: Ip of the terminal, tcp/ip port of the terminal, Native Socket (true or false), Max Attempts

```
$hardware_os_terminal->SetTerminalSettings("192.168.120.136","8080", 30, false, 3);
```

Start a transaction for 0,1 €
```
if ($hardware_os_terminal->check_Terminal_hardware()) 
{
    $TestUUID = $hardware_os_terminal->GUID32();
    $hardware_os_terminal->generate_manually_transaction_details("10", $TestUUID);
    $hardware_os_terminal->send_payment_request_IM30();
}
```

## Based on documentation from VIVA Wallet

### Viva Wallet IM 30 Sales Request
https://developer.vivawallet.com/apis-for-point-of-sale/card-terminals-devices/vivawallet-api-cl/sale/#txsalerequest

### Viva Wallet IM 30 Sales Response
https://developer.vivawallet.com/apis-for-point-of-sale/card-terminals-devices/vivawallet-api-cl/sale/#txsaleresponse

