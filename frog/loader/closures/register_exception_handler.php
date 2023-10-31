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
    echo view($params, $path);
    return true;
};
    set_exception_handler($callback);
    return 'success';
};