<?php

include_once "VivaTerminal_IM30.php";

$hardware_os_terminal = new VivaTerminal_IM30();
$hardware_os_terminal->InDebugMode = true; // Enabled debug to show information 
$hardware_os_terminal->SetTerminalSettings("192.168.120.136","8080", 30, false, 3);

if ($hardware_os_terminal->check_Terminal_hardware()) 
{
    $TestUUID = $hardware_os_terminal->GUID32();
    $hardware_os_terminal->generate_manually_transaction_details("0.01", $TestUUID);
    $hardware_os_terminal->send_payment_request_IM30();
}

?>
