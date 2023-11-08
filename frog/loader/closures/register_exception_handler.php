<?php
namespace castle;
return function (array &$vals) : string
{
    $callback = function (\Throwable $throwable) use ($vals)
{
    $path = $vals['views_dir'] . 'castle/__503__.php';
    $params = [
        'message' => $throwable->getMessage(),
        'file' => $throwable->getFile() . '(' . $throwable->getLine() . ')',
    ];
    set_status(FRG_HTTP_STATUS_CODE_503_SERVICE_UNAVAILABLE);
    send_status_line();
    send_headers();
    echo view($params, $path);
    $vals['end_with'] = "exception_handler";
    $vals['message'] = $throwable->getMessage();
    $vals['file'] = $throwable->getFile() . '(' . $throwable->getLine() . ')';
    file_put_contents($vals['syslog_dir']  . $vals['syslog_id'] . '.json', json_encode($vals, JSON_PRETTY_PRINT));
    die;
};
    set_exception_handler($callback);
    return 'success';
};