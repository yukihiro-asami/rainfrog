<?php
namespace castle;

return function (array &$vals) : string
{
    global $__db_logs, $__status, $__headers, $__mode;
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
    $vals['db_log'] = $__db_logs;
    $vals['http_response_status_code'] = $__status;
    $vals['http_headers'] = $__headers;
    $vals['mode'] = $__mode;
    $vals['end_with'] = "store_syslog";
    if ($vals['is_syslog_enabled'])
    {
        file_put_contents($vals['syslog_dir']  . $vals['syslog_id'] . '.json', json_encode($vals, JSON_PRETTY_PRINT));
        if ($__mode === FRG_MODE_TASK)
            echo 'syslog path: ' . '"' . $vals['syslog_dir']  . $vals['syslog_id'] . '.json"' . PHP_EOL;
    }
    return 'success';
};