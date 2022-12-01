<?php
namespace castle;
return function (array &$vals) : string
{
    $callback = function (\Throwable $t) use ($vals)
{
    $path = $vals['views_dir'] . 'castle/__503__.php';
    echo view(['message' => $t->getMessage()], $path);
    return true;
};
    //set_exception_handler($callback);
    return 'success';
};