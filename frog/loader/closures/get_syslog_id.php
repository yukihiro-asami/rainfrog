<?php
namespace castle;
return function (array &$vals) : string
{
    $vals['syslog_id'] = generate_token('xuvVRxnDCw0ddjdK', 8) . '|' . _base64_encode_url_safe(pack('i', time() + 3600 ));
    return 'success';
};