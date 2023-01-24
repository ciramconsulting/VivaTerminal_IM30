<?php

/*
Created by Jan Muyldermans for VIVA Terminal Integration
*/

class VivaTerminal_IM30
{
    // Enabled this to show debug information on screen.
    public $InDebugMode = false;
    public $InCliMode = false;

    // This is a unqiue code from the payment terminal and is created in the Viva Wallet Platform, is stored in the MAc Address field of PArkingSpot Software.
    public  $TerminalsourceCode;
    public  $TerminalID;
    public  $SearchResultPOS;
    public  $TerminalCashRegisterId;
   
    // Settings for the Terminal
    private $Terminal_IP;
    private $Terminal_PORT;
    private $Terminal_WAIT;

    private $Terminal_NATIVE_SOCKET = false;
    public $Terminal_Transaction_MSG;
    public $Terminal_Transaction_ID;
    public $Terminal_MAX_RETRY = 0;
    public $Terminal_Current_attempts = 0;

    // Database Object
    private $ApiBridge;

    public function SetTerminalSettings($IpOfTerminal, $PortOfTerminal, $PortWait, $NativeSocket = false, $MaxRetry = 1) {
        $this->Terminal_IP = $IpOfTerminal;
        $this->Terminal_PORT = $PortOfTerminal;
        $this->Terminal_WAIT = $PortWait;
        $this->Terminal_NATIVE_SOCKET = $NativeSocket;
        $this->Terminal_MAX_RETRY = $MaxRetry;
        $this->Terminal_Current_attempts = 0;
    }

    public function __construct() {     
        if (php_sapi_name() == "cli") { $this->InCliMode = true; } else { $this->InCliMode = false; }
    }
  
    
    public function generate_transaction_details() {
        // Add Custom code here, if needed
        $this->Terminal_Transaction_ID = random_int(100000, 999999);
        // Example price
        $Price = "0.71";
        $this->Terminal_Transaction_MSG = "0107|". $this->Terminal_Transaction_ID . "|200|00|" . $this->GUID32() . "|".  $Price ."|0000|||||0.10||||ecr_default";
    }

    public function generate_manually_transaction_details($amount, $uuidtrans) {
        $this->Terminal_Transaction_ID = random_int(100000, 999999);
        $this->Terminal_Transaction_MSG = "0107|". $this->Terminal_Transaction_ID . "|200|00|" . $uuidtrans . "|".  $amount ."|0000|||||0.10||||ecr_default";
    }

    public function check_Terminal_hardware() {
        $fp = fSockOpen($this->Terminal_IP, $this->Terminal_PORT, $errno, $errstr, 2); 
        return $fp!=false;
    }
   
    public function send_payment_request_IM30() {
        $this->Terminal_Current_attempts = $this->Terminal_Current_attempts + 1;
        $ReturnWaarde = "";
        $this->Internal_Show_Info("Attemp: " .  $this->Terminal_Current_attempts . "/" . $this->Terminal_MAX_RETRY);
        $this->Internal_Show_Info("Send message: " .  $this->Terminal_Transaction_MSG);

        if ($this->Terminal_NATIVE_SOCKET) {
            // TODO: Native Socket (only for CLI PHP.)
            // create socket
            $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
            $result = socket_connect($socket, $this->Terminal_IP, $this->Terminal_PORT) or die("Could not connect to server\n"); 
            socket_write($socket, $this->Terminal_Transaction_MSG, strlen($this->Terminal_Transaction_MSG)) or die("Could not send data to server\n");
            $result = socket_read ($socket, 1024) or die("Could not read server response\n");
            echo "Reply From Server :".$result;
            socket_close($socket);
        } else {
            set_time_limit($this->Terminal_WAIT); // No Timeout
            $fp = fsockopen($this->Terminal_IP, $this->Terminal_PORT, $errno, $errstr, $this->Terminal_WAIT);
            if (!$fp) {
               
            } else {
                fwrite($fp, $this->Terminal_Transaction_MSG);
                while (!feof($fp)) {
                    $ReturnWaarde =  $ReturnWaarde . fread($fp,256);
                }
                fclose($fp);
            }
            $ArrayPOS = explode("|", $ReturnWaarde);
            $this->Internal_Show_Info("Return: " . $ReturnWaarde);

            if ($ArrayPOS[7] <> '00') {
                 $this->Internal_Show_Info("Failed card: " . $ArrayPOS[9]);
                 $this->Internal_Show_Info("Failed code: " .  $ArrayPOS[7]);
                 // Wait a second to restart the new attempt.
                 sleep(1);
                 if ($this->Terminal_Current_attempts < $this->Terminal_MAX_RETRY) {
                    $this->send_payment_request_IM30();
                 } else {
                    $this->Internal_Show_Info("Info: Maximum number of attempts reached");
                 }
            }

           
        }

      
      
     
    }
    
    public function Internal_Show_Info($Message) {
        $NewLine = "<br>";
        if ($this->InCliMode) { $NewLine = "\n"; }
        if ($this->InDebugMode) {
            echo $Message . $NewLine;
        }
    }

    public function GUID32() {
        return strtoupper(bin2hex(openssl_random_pseudo_bytes(16)));
    }

    
}

?>
