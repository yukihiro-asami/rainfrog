<?php /** @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection */

namespace castle;
return function (array &$vals) : string
{
    $callback = function ($errno, $errstr, $errfile, $errline) use ($vals)
{
    $path = $vals['views_dir'] . 'castle/__503__.php';
    $params = [
        'message' => $errno . $errstr,
        'file' => $errfile . '(' . $errline . ')',
    ];
    set_status(FRG_HTTP_STATUS_CODE_503_SERVICE_UNAVAILABLE);
    send_status_line();
    send_headers();
    echo view($params, $path);
    $vals['end_with'] = "error_handler";
    $vals['message'] = $errno . $errstr;
    $vals['file'] = $errfile . '(' . $errline . ')';
    file_put_contents($vals['syslog_dir']  . $vals['syslog_id'] . '.json', json_encode($vals, JSON_PRETTY_PRINT));
    die;
};
    set_error_handler($callback);
    return 'success';
};