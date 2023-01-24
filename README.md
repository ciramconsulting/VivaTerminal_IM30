# VivaTerminal_IM30
PHP Class to use IM30 Terminal, copyright Ciram Consulting BV.

If you want to use this code contact us.

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

Start a transaction
```
if ($hardware_os_terminal->check_Terminal_hardware()) 
{
    $TestUUID = $hardware_os_terminal->GUID32();
    $hardware_os_terminal->generate_manually_transaction_details("0.01", $TestUUID);
    $hardware_os_terminal->send_payment_request_IM30();
}
```
