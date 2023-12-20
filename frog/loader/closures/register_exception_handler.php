<?php
namespace castle;
return function (array &$vals) : string
{
    $callback = function (\Throwable $throwable) use ($vals)
{
    global $__db_logs, $__status, $__headers, $__mode;
    $path = $vals['views_dir'] . 'castle/__503__.php';
    $params = [
        'message' => $throwable->getMessage(),
        'file' => $throwable->getFile() . '(' . $throwable->getLine() . ')',
    ];
    set_status(FRG_HTTP_STATUS_CODE_503_SERVICE_UNAVAILABLE);
    send_status_line();
    send_headers();
    echo view($params, $path);
    $vals['db_log'] = $__db_logs;
    $vals['http_response_status_code'] = $__status;
    $vals['http_headers'] = $__headers;
    $vals['mode'] = $__mode;
    $vals['end_with'] = "exception_handler";
    $vals['message'] = $throwable->getMessage();
    $vals['file'] = $throwable->getFile() . '(' . $throwable->getLine() . ')';
    /** @noinspection DuplicatedCode */
    if ($vals['is_syslog_enabled'])
    {
        file_put_contents($vals['syslog_dir']  . $vals['syslog_id'] . '.json', json_encode($vals, JSON_PRETTY_PRINT));
        if ($__mode === FRG_MODE_TASK)
            echo 'syslog path: ' . '"' . $vals['syslog_dir']  . $vals['syslog_id'] . '.json"' . PHP_EOL;
    }
    die;
};
    set_exception_handler($callback);
    return 'success';
};