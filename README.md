# VivaTerminal_IM30
PHP Class to use IM30 Terminal

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

BSD 3-Clause License

Copyright (c) 2023, Ciram Consulting

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its
   contributors may be used to endorse or promote products derived from
   this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
