<?php
namespace castle;

return function (array &$vals) : string
{
    foreach (scandir($vals['syslog_dir']) as $file_name)
    {
        if (in_array($file_name, ['.', '..']) === true)
            continue;
        if (
            unpack('l',
                _base64_decode_url_safe(
                    (string) _explode_recursively(['.', '|'], $file_name)[0][1] ?? 'AAAAAA'
                )
            )[1] < time()
        )
            unlink($vals['syslog_dir'] . $file_name);
    }
    file_put_contents($vals['syslog_dir']  . $vals['syslog_id'] . '.json', json_encode($vals, JSON_PRETTY_PRINT));
    return 'success';
};