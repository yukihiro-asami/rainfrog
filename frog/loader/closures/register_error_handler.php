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
    echo view($params, $path);
    die;
};
    set_error_handler($callback);
    return 'success';
};